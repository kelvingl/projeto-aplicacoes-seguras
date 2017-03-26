AddEdit = {
    dialog: null,
    nome: null,
    login: null,
    senha: null,
    grupo: null,
    _target: null,
    allFields: null,
    init: function () {
        AddEdit.nome = $("#nome");
        AddEdit.login = $("#login");
        AddEdit.grupo = $("#grupo");
        AddEdit.senha = $("#senha");
        AddEdit.allFields = $([]).add(AddEdit.nome).add(AddEdit.login).add(AddEdit.grupo).add(AddEdit.senha);
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
        AddEdit.login.val(tr.find("[data-field=\"login\"]:first").html());
        AddEdit.grupo.val(tr.find("[data-field=\"grupo\"]:first").attr('data-grupo'));
        AddEdit._target.val($(this).attr('data-href'));
        AddEdit._target.attr('data-method', 'PUT');
        AddEdit.dialog.dialog('open');
    },
    openDialogAdd: function(e)
    {
        e.preventDefault();
        AddEdit.nome.val("");
        AddEdit.login.val("")
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
            dataType: "json",
            success: function(data) {
                if (!data.success) {
                    if(data.message) {
                        alert(data.message);
                    }
                }
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