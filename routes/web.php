<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// ─── Sitemap ───────────────────────────────────────────────────────────────
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

// ─── Redirection vers la langue par défaut ─────────────────────────────────
Route::redirect('/', '/de');

// ═══════════════════════════════════════════════════════════════════════════
// FRONT OFFICE — Routes publiques avec préfixe de langue /{locale}
// Langues supportées : fr | en | de
// ═══════════════════════════════════════════════════════════════════════════
Route::prefix('{locale}')
    ->where(['locale' => 'fr|en|de'])
    ->middleware(\App\Http\Middleware\SetLocale::class)
    ->group(function () {

        // Page d'accueil
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Catalogue véhicules
        Route::get('/vehicules', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/vehicules/{id}', [VehicleController::class, 'show'])
            ->where('id', '[0-9]+')
            ->name('vehicles.show');

        // Traçage clic WhatsApp (crée un lead anonyme, redirige vers la fiche)
        Route::post('/vehicules/{vehicle}/whatsapp', [ContactController::class, 'trackWhatsApp'])
            ->name('vehicles.whatsapp')
            ->where('vehicle', '[0-9]+')
            ->middleware('throttle:public-forms');

        // Service export
        Route::get('/export', [ExportController::class, 'index'])->name('export');
        Route::post('/export', [ExportController::class, 'store'])->name('export.store')->middleware('throttle:public-forms');

        // À propos
        Route::get('/a-propos', [AboutController::class, 'index'])->name('about');

        // Contact
        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:public-forms');

        // Pages légales — contrôleur dédié (requis pour route:cache)
        Route::get('/mentions-legales',        [StaticPageController::class, 'legal'])  ->name('legal');
        Route::get('/conditions-generales',    [StaticPageController::class, 'terms'])  ->name('terms');
        Route::get('/politique-confidentialite',[StaticPageController::class, 'privacy'])->name('privacy');

        // Landing pages SEO
        Route::get('/import-car-from-germany-to-france', [StaticPageController::class, 'importFromGermany'])
            ->name('landing.import_germany_france');
        Route::get('/used-cars-germany',    [StaticPageController::class, 'usedCarsGermany'])
            ->name('landing.used_cars_germany');
        Route::get('/car-export-germany',   [StaticPageController::class, 'carExportGermany'])
            ->name('landing.car_export_germany');
        Route::get('/bmw-germany',          [StaticPageController::class, 'bmwGermany'])
            ->name('landing.bmw_germany');
        Route::get('/audi-germany',         [StaticPageController::class, 'audiGermany'])
            ->name('landing.audi_germany');
        Route::get('/mercedes-germany',     [StaticPageController::class, 'mercedesGermany'])
            ->name('landing.mercedes_germany');
    });

// ═══════════════════════════════════════════════════════════════════════════
// BACK OFFICE — Administration (préfixe /admin)
// ═══════════════════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->middleware('setAdminLocale')->group(function () {

    // ─── Langue admin — contrôleur dédié (requis pour route:cache) ────────
    Route::post('/lang', [Admin\LanguageController::class, 'switch'])->name('lang');

    // ─── Authentification (accès public) ──────────────────────────────────
    Route::get('/connexion', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion', [Admin\AuthController::class, 'login'])->name('login.post')->middleware('throttle:login');
    Route::post('/deconnexion', [Admin\AuthController::class, 'logout'])->name('logout');

    // ─── Réinitialisation de mot de passe (accès public) ──────────────────
    Route::get('/mot-de-passe/demande', [Admin\PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/mot-de-passe/demande', [Admin\PasswordResetController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:login');
    Route::get('/mot-de-passe/reset/{token}', [Admin\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/mot-de-passe/reset', [Admin\PasswordResetController::class, 'resetPassword'])->name('password.update');

    // ─── Zone protégée (authentification requise) ─────────────────────────
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {

        // Tableau de bord
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // ─── Marques (admin uniquement) ────────────────────────────────────
        Route::middleware('admin-only')
            ->group(fn () => Route::resource('marques', Admin\BrandController::class)
                ->parameters(['marques' => 'marque']));

        // ─── Véhicules — lecture (tous les rôles) ─────────────────────────
        Route::get('vehicules', [Admin\VehicleController::class, 'index'])->name('vehicules.index');
        Route::get('vehicules/{vehicle}', [Admin\VehicleController::class, 'show'])
            ->name('vehicules.show')
            ->where('vehicle', '[0-9]+');

        // ─── Véhicules — mutations (admin uniquement) ─────────────────────
        Route::middleware('admin-only')->group(function () {
            Route::get('vehicules/create', [Admin\VehicleController::class, 'create'])->name('vehicules.create');
            Route::post('vehicules', [Admin\VehicleController::class, 'store'])->name('vehicules.store');
            Route::get('vehicules/{vehicle}/edit', [Admin\VehicleController::class, 'edit'])->name('vehicules.edit')->where('vehicle', '[0-9]+');
            Route::put('vehicules/{vehicle}', [Admin\VehicleController::class, 'update'])->name('vehicules.update')->where('vehicle', '[0-9]+');
            Route::patch('vehicules/{vehicle}', [Admin\VehicleController::class, 'update'])->where('vehicle', '[0-9]+');
            Route::delete('vehicules/{vehicle}', [Admin\VehicleController::class, 'destroy'])->name('vehicules.destroy')->where('vehicle', '[0-9]+');

            // Import CSV
            Route::post('vehicules/import', [Admin\VehicleImportController::class, 'store'])->name('vehicules.import');
            Route::get('vehicules/import/modele', [Admin\VehicleImportController::class, 'downloadTemplate'])->name('vehicules.import.template');

            // Images
            Route::post('vehicules/{vehicle}/images', [Admin\VehicleImageController::class, 'store'])->name('vehicles.images.store')->where('vehicle', '[0-9]+');
            Route::delete('vehicules/{vehicle}/images/{image}', [Admin\VehicleImageController::class, 'destroy'])->name('vehicles.images.destroy')->where(['vehicle' => '[0-9]+', 'image' => '[0-9]+']);
            Route::patch('vehicules/{vehicle}/images/{image}/principale', [Admin\VehicleImageController::class, 'setMain'])->name('vehicles.images.setMain')->where(['vehicle' => '[0-9]+', 'image' => '[0-9]+']);
            Route::post('vehicules/{vehicle}/images/reorder', [Admin\VehicleImageController::class, 'reorder'])->name('vehicles.images.reorder')->where('vehicle', '[0-9]+');
        });

        // ─── Leads (tous les rôles) ────────────────────────────────────────
        Route::resource('leads', Admin\LeadController::class)
            ->only(['index', 'show', 'update', 'destroy']);
        Route::post('leads/{lead}/statut', [Admin\LeadController::class, 'updateStatus'])->name('leads.status');
        Route::post('leads/{lead}/anonymiser', [Admin\LeadController::class, 'anonymize'])->name('leads.anonymize');

        // ─── Utilisateurs & audit (admin uniquement) ───────────────────────
        Route::middleware('admin-only')->group(function () {
            Route::resource('utilisateurs', Admin\UserController::class)
                ->parameters(['utilisateurs' => 'user']);
            Route::get('logs', [Admin\AuditLogController::class, 'index'])->name('audit-logs');
        });
    });
});
