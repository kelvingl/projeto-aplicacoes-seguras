AddEdit = {
    dialog: null,
    nome: null,
    administrador: null,
    _target: null,
    allFields: null,
    init: function () {
        AddEdit.nome = $("#nome");
        AddEdit.administrador = $("#admin");
        AddEdit.allFields = $([]).add(AddEdit.nome).add(AddEdit.administrador);
        AddEdit._target = $("#_target");
        AddEdit.dialog = $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 400,
            width: 350,
            modal: true,
            buttons: {
                "Adicionar/modificar registro": AddEdit.edit,
                Cancel: function() {
                    AddEdit.dialog.dialog( "close" );
                }
            },
            close: function() {
                document.forms[ 0 ].reset();
                AddEdit.allFields.removeClass( "ui-state-error" );
            }
        });
        $(".btn-editar").click(AddEdit.openDialogEdit);
        $(".btn-cadastrar").click(AddEdit.openDialogAdd);
        $(".btn-excluir").click(AddEdit.excluir);
        $('#form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        $('#form').on('submit', function(e){e.preventDefault();})
    },
    openDialogEdit: function(e)
    {
        e.preventDefault();
        tr = $(this).parents("tr:first");
        AddEdit.nome.val(tr.find("[data-field=\"nome\"]:first").html());
        AddEdit.administrador.val(tr.find("[data-field=\"admin\"]:first").attr('data-value'))
        AddEdit._target.val($(this).attr('data-href'));
        AddEdit._target.attr('data-method', 'PUT');
        AddEdit.dialog.dialog('open');
    },
    openDialogAdd: function(e)
    {
        e.preventDefault();
        AddEdit.nome.val("");
        AddEdit.administrador.val("0")
        AddEdit._target.val($(this).attr('data-href'));
        AddEdit._target.attr('data-method', 'POST');
        AddEdit.dialog.dialog('open');
    },
    edit: function()
    {
        url = AddEdit._target.val();
        $.ajax({
            url: AddEdit._target.val(),
            type: AddEdit._target.attr('data-method'),
            data: AddEdit.allFields.serialize(),
            success: function(data) {
                window.location.reload();
            }
        });
    },
    excluir: function()
    {
        $.ajax({
            url: $(this).attr('data-href'),
            type: 'DELETE',
            success: function(data) {
                window.location.reload();
            }
        });
    }

};
$(AddEdit.init);