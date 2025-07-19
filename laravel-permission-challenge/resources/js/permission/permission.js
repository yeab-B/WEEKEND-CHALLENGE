import ListHandler from "../base/ListHandler";



export class PermissionListHandler extends ListHandler {
    constructor(options) {
        super({
            ...options,
            entityName: 'permission',
            routeName: 'permissions',
            modalAddFormId: 'permissionCreateModal',
            modalEditFormId: 'permissionEditModal',
            modalViewFormId: 'permissionViewModal',
        });
    }

    initEmployeeSelect2() {
        // Use the generic function for this modal
        const $select = $('.select2-ajax[name="user_id"]');
        initEmployeeSelect2($select);
    }

    setupEventListeners() {
        super.setupEventListeners();
        const namespace = `.${this.entityName}Handler`;

        // Re-initialize Select2 when modal is shown (create or edit)
        $(document).on('shown.bs.modal', `#${this.modalAddFormId}, #${this.modalEditFormId}`, () => {
            this.initEmployeeSelect2();
        });
    } 
}

export class RoleListHandler extends ListHandler {
    constructor(options) {
        super({
            ...options,
            entityName: 'role',
            routeName: 'roles',
            modalAddFormId: 'roleCreateModal',
            modalEditFormId: 'roleEditModal',
            modalViewFormId: 'roleViewModal',
        });
    }

   

    setupEventListeners() {
        super.setupEventListeners();
        const namespace = `.${this.entityName}Handler`;

        // Re-initialize Select2 when modal is shown (create or edit)
        $(document).on('shown.bs.modal', `#${this.modalAddFormId}, #${this.modalEditFormId}`, () => {
            this.initEmployeeSelect2();
        });
    }
}
export class UserListHandler extends ListHandler {
    constructor(options) {
        super({
            ...options,
            entityName: 'user',
            routeName: 'users',
            modalAddFormId: 'userCreateModal',
            modalEditFormId: 'userEditModal',
            modalViewFormId: 'userViewModal',
        });
    }

  
    setupEventListeners() {
        super.setupEventListeners();
        const namespace = `.${this.entityName}Handler`;

        // Re-initialize Select2 when modal is shown (create or edit)
        $(document).on('shown.bs.modal', `#${this.modalAddFormId}, #${this.modalEditFormId}`, () => {
            this.initEmployeeSelect2();
        });
    }
}