<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Vérification : seuls les admins peuvent gérer les utilisateurs
    private function checkAdmin(): void
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }

    // Liste des utilisateurs
    public function index()
    {
        $this->checkAdmin();
        $users = User::latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    // Formulaire de création d'un utilisateur
    public function create()
    {
        $this->checkAdmin();
        return view('admin.users.create');
    }

    // Enregistrement d'un nouvel utilisateur
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'role'                  => ['required', 'in:admin,commercial'],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        AuditService::log('create', 'user', $user->id);

        return redirect()
            ->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    // Formulaire d'édition d'un utilisateur
    public function edit(User $user)
    {
        $this->checkAdmin();
        return view('admin.users.edit', compact('user'));
    }

    // Mise à jour d'un utilisateur
    public function update(Request $request, User $user)
    {
        $this->checkAdmin();

        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'      => ['required', 'in:admin,commercial'],
            'is_active' => ['boolean'],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = $request->only(['name', 'email', 'role', 'is_active']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        AuditService::log('update', 'user', $user->id);

        return redirect()
            ->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur mis à jour.');
    }

    // Suppression d'un utilisateur
    public function destroy(User $user)
    {
        $this->checkAdmin();

        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $user->delete();
        AuditService::log('delete', 'user', $user->id);

        return redirect()
            ->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}
