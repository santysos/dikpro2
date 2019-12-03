$("#Cliente").keyup(event => {
    $.get(`bcli/${event.target.value}`, function(res) {
        $("#NombreComercial").val("");
        $("#CodigoCliente").val("");
        $("#Cedula_Ruc").val("");
        $("#Telefono").val("");
        $("#Email").val("");
        $(res).each(function(key, value) {
            $("#NombreComercial").val(res.Cliente_Nombre_Comercial + " - " + res.Contacto_Razon_Social);
            $("#CodigoCliente").val(res.id_tb_cliente);
            $("#Cedula_Ruc").val(res.Cedula_Ruc);
            $("#Telefono").val(res.Telefono);
            $("#Email").val(res.Email);
        });
    });
});
/*
$("#Cliente").keyup(event => {
    $.get(`bcli/${event.target.value}`, function(res) {
        $("#NombreComercial").val("");
        $("#CodigoCliente").val("");
        $("#Cedula_Ruc").val("");
        $("#Telefono").val("");
        $("#Email").val("");
        $(res).each(function(key, value) {
            $("#NombreComercial").val(res[0].Cliente_Nombre_Comercial + " - " + res[0].Contacto_Razon_Social);
            $("#CodigoCliente").val(res[0].id_tb_cliente);
            $("#Cedula_Ruc").val(res[0].Cedula_Ruc);
            $("#Telefono").val(res[0].Telefono);
            $("#Email").val(res[0].Email);
        });
    });
});
*/