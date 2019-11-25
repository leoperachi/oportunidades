$.extend( true, $.fn.dataTable.defaults, {
    "dom": '<"top">rt<"bottom"ip><"clear">',
    "language": {
        "paginate": {
            "first":      '<i class="fa fa-fast-backward"></i>',
            "previous":   '<i class="fa fa-backward"></i>',
            "next":       '<i class="fa fa-forward"></i>',
            "last":       '<i class="fa fa-fast-forward"></i>'
        },
        "info": '<label style="font-weight: bold;">Exibindo _PAGE_ de _PAGES_</label>',
        "emptyTable": 'Sem Registros',
        "pageLength": 50
    }
} );