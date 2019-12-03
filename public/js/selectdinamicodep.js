$("#id_tb_departamentos").change(event => {
    $.get(`tm/${event.target.value}`, function(res, sta) {
        $("#id_tb_tipo_empleados").empty();
        res.forEach(element => {
            $("#id_tb_tipo_empleados").append(`<option value=${element.id_tb_tipo_empleados}> ${element.tipo_empleados} </option>`);
        });
    });
});