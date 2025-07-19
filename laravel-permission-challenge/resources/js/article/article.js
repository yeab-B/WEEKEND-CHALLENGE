import ListHandler from "../base/ListHandler";



export class ArticleListHandler extends ListHandler {
    constructor(options) {
        super({
            ...options,
            entityName: 'article',
            routeName: 'articles',
            modalAddFormId: 'articleCreateModal',
            modalEditFormId: 'articleEditModal',
            modalViewFormId: 'articleViewModal',
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
