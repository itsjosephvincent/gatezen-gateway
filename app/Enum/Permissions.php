<?php

namespace App\Enum;

enum Permissions: string
{
    case ViewUser = 'view users';
    case CreateUser = 'create users';
    case UpdateUser = 'update users';
    case DeleteUser = 'delete users';
    case ViewRoles = 'view roles';
    case CreateRoles = 'create roles';
    case UpdateRoles = 'update roles';
    case DeleteRoles = 'delete roles';
    case ViewPermissions = 'view permissions';
    case CreatePermissions = 'create permissions';
    case UpdatePermissions = 'update permissions';
    case DeletePermissions = 'delete permissions';
    case ViewProjects = 'view projects';
    case CreateProjects = 'create projects';
    case UpdateProjects = 'update projects';
    case DeleteProjects = 'delete projects';
    case ViewWallets = 'view wallets';
    case CreateWallets = 'create wallets';
    case UpdateWallets = 'update wallets';
    case DeleteWallets = 'delete wallets';
}
