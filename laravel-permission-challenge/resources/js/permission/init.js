import{
    PermissionListHandler,
    RoleListHandler,
    UserListHandler

}from './permission';


if (document.getElementById('permission-search-form')) {
    new PermissionListHandler({
        indexRoute: AppData.PermissionsIndexRoute,
        csrfToken: AppData.csrfToken,
    });
}
if (document.getElementById('role-search-form')) {
    new RoleListHandler({
        indexRoute:AppData.RolesIndexRoute,
        csrfToken: AppData.csrfToken,

    });
}
if (document.getElementById('user-search-form')) {
    new UserListHandler({
        indexRoute:AppData.UsersIndexRoute,
        csrfToken: AppData.csrfToken,

    });
}


