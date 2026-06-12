<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Services\AuditService;
use Illuminate\Http\Request;

class VehicleImportController extends Controller
{
    // Valeurs autorisées par colonne
    private const ALLOWED = [
        'vehicle_type' => ['cabriolet_roadster', 'suv_pickup', 'citadine', 'break', 'berline', 'monospace_minibus', 'sport_coupe', 'autre'],
        'condition'    => ['neuf', 'occasion'],
        'seller_type'  => ['concessionnaire', 'particulier', 'societe'],
        'fuel_type'    => ['essence', 'diesel', 'electrique', 'bioethanol', 'hybride_essence', 'hybride_plug_in', 'gaz_naturel', 'hybride_rechargeable', 'gpl', 'autre'],
        'transmission' => ['automatique', 'semi_automatique', 'manuelle', ''],
        'status'       => ['actif', 'inactif', 'vendu'],
        'drive'        => ['4x4', 'traction_avant', 'propulsion', ''],
    ];

    // Normalise certaines valeurs courantes vers les valeurs attendues
    private const NORMALIZE = [
        'vehicle_type' => [
            'suv'        => 'suv_pickup',
            'pickup'     => 'suv_pickup',
            'compacte'   => 'citadine',
            'hatchback'  => 'citadine',
            'coupe'      => 'sport_coupe',
            'coupé'      => 'sport_coupe',
            'roadster'   => 'cabriolet_roadster',
            'cabriolet'  => 'cabriolet_roadster',
            'minibus'    => 'monospace_minibus',
            'monospace'  => 'monospace_minibus',
            'van'        => 'monospace_minibus',
        ],
        'fuel_type' => [
            'hybride'          => 'hybride_essence',
            'hybrid'           => 'hybride_essence',
            'electric'         => 'electrique',
            'électrique'       => 'electrique',
            'electrique'       => 'electrique',
            'plug-in'          => 'hybride_plug_in',
            'rechargeable'     => 'hybride_rechargeable',
            'gaz'              => 'gaz_naturel',
            'cng'              => 'gaz_naturel',
            'lpg'              => 'gpl',
            'bio'              => 'bioethanol',
        ],
        'drive' => [
            'intégrale'    => '4x4',
            'integrale'    => '4x4',
            '4wd'          => '4x4',
            'awd'          => '4x4',
            '4motion'      => '4x4',
            'quattro'      => '4x4',
            'xdrive'       => '4x4',
            'traction'     => 'traction_avant',
            'fwd'          => 'traction_avant',
            'rwd'          => 'propulsion',
            'arrière'      => 'propulsion',
            'arriere'      => 'propulsion',
        ],
        'transmission' => [
            'auto'         => 'automatique',
            'dsg'          => 'automatique',
            'cvt'          => 'automatique',
            'manual'       => 'manuelle',
            'manuell'      => 'manuelle',
            'semi-auto'    => 'semi_automatique',
            'semi auto'    => 'semi_automatique',
        ],
    ];

    public function store(Request $request)
    {
        $request->validate([
            'import_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $file = $request->file('import_file');

        // Ouvre en UTF-8 et retire le BOM éventuel (ï»¿ / \xEF\xBB\xBF)
        $handle = fopen($file->getRealPath(), 'r');
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle); // pas de BOM, on repart du début
        }

        // Lecture de l'en-tête
        $headers = fgetcsv($handle, 0, ',');
        if (!$headers) {
            return back()->withErrors(['import_file' => 'Fichier CSV vide ou invalide.']);
        }
        $headers = array_map('trim', $headers);

        $required = ['brand_id', 'model', 'vehicle_type', 'condition', 'seller_type', 'year', 'mileage', 'price', 'fuel_type', 'status'];
        $missing  = array_diff($required, $headers);
        if ($missing) {
            fclose($handle);
            return back()->withErrors(['import_file' => 'Colonnes requises manquantes : ' . implode(', ', $missing)]);
        }

        $imported = 0;
        $skipped  = 0;
        $errors   = [];
        $lineNum  = 1;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $lineNum++;

            if (count($row) !== count($headers)) {
                $errors[] = "Ligne {$lineNum} ignorée : nombre de colonnes incorrect.";
                $skipped++;
                continue;
            }

            $data = array_combine($headers, array_map('trim', $row));

            // Normalisation des valeurs courantes vers les valeurs attendues
            foreach (self::NORMALIZE as $field => $map) {
                if (!isset($data[$field]) || $data[$field] === '') continue;
                $lower = mb_strtolower($data[$field]);
                if (isset($map[$lower])) {
                    $data[$field] = $map[$lower];
                }
            }

            // Vérification des champs requis
            $rowErrors = [];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    $rowErrors[] = $field;
                }
            }
            if ($rowErrors) {
                $errors[] = "Ligne {$lineNum} ignorée : champ(s) requis vide(s) → " . implode(', ', $rowErrors);
                $skipped++;
                continue;
            }

            // Validation des valeurs enum
            foreach (self::ALLOWED as $field => $allowed) {
                if (isset($data[$field]) && $data[$field] !== '' && !in_array($data[$field], $allowed)) {
                    $errors[] = "Ligne {$lineNum} ignorée : valeur invalide pour « {$field} » → « {$data[$field]} ». Valeurs acceptées : " . implode(', ', array_filter($allowed));
                    $skipped++;
                    continue 2;
                }
            }

            // Validation année
            $year = (int) ($data['year'] ?? 0);
            if ($year < 1950 || $year > (date('Y') + 1)) {
                $errors[] = "Ligne {$lineNum} ignorée : année invalide ({$data['year']}).";
                $skipped++;
                continue;
            }

            // Résolution de la marque par ID
            $brandId = (int) ($data['brand_id'] ?? 0);
            $brand   = Brand::find($brandId);
            if (!$brand) {
                $errors[] = "Ligne {$lineNum} ignorée : marque ID {$brandId} introuvable.";
                $skipped++;
                continue;
            }

            // Construction du tableau de données
            $vehicleData = [
                'brand_id'     => $brand->id,
                'model'        => $data['model'],
                'version'      => $data['version']      ?? null,
                'vehicle_type' => $data['vehicle_type'],
                'condition'    => $data['condition'],
                'seller_type'  => $data['seller_type'],
                'year'         => $year,
                'mileage'      => max(0, (int) ($data['mileage'] ?? 0)),
                'price'        => max(0, (float) ($data['price'] ?? 0)),
                'ancien_prix'  => isset($data['ancien_prix']) && $data['ancien_prix'] !== '' ? max(0, (float) $data['ancien_prix']) : null,
                'fuel_type'    => $data['fuel_type'],
                'status'       => $data['status'] ?: 'actif',
                // Optionnels
                'transmission'      => $data['transmission']      ?? null ?: null,
                'drive'             => $data['drive']             ?? null ?: null,
                'power_hp'          => isset($data['power_hp'])          && $data['power_hp']          !== '' ? (int) $data['power_hp']          : null,
                'power_kw'          => isset($data['power_kw'])          && $data['power_kw']          !== '' ? (int) $data['power_kw']          : null,
                'cylinder'          => isset($data['cylinder'])          && $data['cylinder']          !== '' ? (int) $data['cylinder']          : null,
                'doors'             => isset($data['doors'])             && $data['doors']             !== '' ? (int) $data['doors']             : null,
                'seats'             => isset($data['seats'])             && $data['seats']             !== '' ? (int) $data['seats']             : null,
                'exterior_color'    => $data['exterior_color']    ?? null ?: null,
                'interior_color'    => $data['interior_color']    ?? null ?: null,
                'interior_material' => $data['interior_material'] ?? null ?: null,
                'country'           => $data['country']           ?? null ?: null,
                'city'              => $data['city']              ?? null ?: null,
                'vin'               => $data['vin']               ?? null ?: null,
                'description'       => $data['description']       ?? null ?: null,
                'warranty'         => !empty($data['warranty'])         && $data['warranty']         !== '0',
                'service_book'     => !empty($data['service_book'])     && $data['service_book']     !== '0',
                'export_available' => !empty($data['export_available']) && $data['export_available'] !== '0',
                'vat_status'       => in_array($data['vat_status'] ?? '', ['recuperable','non_recuperable']) ? $data['vat_status'] : null,
                'safety_compliant' => !empty($data['safety_compliant']) && $data['safety_compliant'] !== '0',
                'full_service'      => !empty($data['full_service'])      && $data['full_service']      !== '0',
                'non_smoker'        => !empty($data['non_smoker'])        && $data['non_smoker']        !== '0',
            ];

            Vehicle::create($vehicleData);
            AuditService::log('import', 'vehicle');
            $imported++;
        }

        fclose($handle);

        $message = "{$imported} véhicule(s) importé(s) avec succès.";
        if ($skipped > 0) {
            $message .= " {$skipped} ligne(s) ignorée(s).";
        }

        return back()
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="modele-vehicules.csv"',
        ];

        $columns = [
            'brand_id', 'model', 'version', 'vehicle_type', 'condition', 'seller_type',
            'year', 'mileage', 'price', 'ancien_prix', 'fuel_type', 'status',
            'transmission', 'drive', 'power_hp', 'power_kw', 'cylinder',
            'doors', 'seats', 'exterior_color', 'interior_color', 'interior_material',
            'country', 'city', 'vin', 'description',
            'warranty', 'service_book', 'export_available', 'vat_status',
            'safety_compliant', 'full_service', 'non_smoker',
        ];

        $example = [
            '1', 'C 220d', 'AMG Line', 'berline', 'occasion', 'concessionnaire',
            '2021', '45000', '29900', '32500', 'diesel', 'actif',
            'automatique', 'propulsion', '200', '147', '1950',
            '4', '5', 'Gris métallisé', 'Noir', 'Cuir',
            'France', 'Paris', 'WDD2050011F123456', 'Très bel état, premier propriétaire',
            '1', '1', '0', 'recuperable',
            '1', '0', '1',
        ];

        $callback = function () use ($columns, $example) {
            $out = fopen('php://output', 'w');
            // BOM UTF-8 pour compatibilité Excel
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $columns);
            fputcsv($out, $example);
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
