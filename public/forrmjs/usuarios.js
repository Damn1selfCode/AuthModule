/*=============================================
LISTADO DE PAISES
=============================================*/



/*=============================================
PLUGIN SELECT 2
=============================================*/

$('.select2').select2()

/*=============================================
AGREGAR DIAL CODE DEL PAIS
=============================================*/

$("#inputPais").change(function(){

	$(".dialCode").html($(this).val().split(",")[2])

})

/*=============================================
INPUT MASK
=============================================*/

$('[data-mask]').inputmask();

/*=============================================
FIRMA VIRTUAL
=============================================*/
$("#signatureparent").jSignature({

  color:"#333", // line color
  lineWidth:1, // Grosor de línea
  // Ancho y alto área de la firma
  idth:320,
  height:100

});

$(".repetirFirma").click(function(){

	$("#signatureparent").jSignature("reset");

})


/*=============================================
VALIDAR FORMULARIO SUSCRIPCIÓN
=============================================*/

$(".suscribirse").click(function(){

	$(".alert").remove();

	var nombre = $("#inputName").val();
	var email = $("#inputEmail").val();
	var patrocinador = $("#inputPatrocinador").val();
	var enlace_afiliado = $("#inputAfiliado").val();
	var pais = $("#inputPais").val().split(",")[0];
	var codigo_pais = $("#inputPais").val().split(",")[1];
	var telefono_movil = $("#inputPais").val().split(",")[2]+" "+$("#inputMovil").val();
	var red = $("#tipoRed").val();
	var aceptarTerminos = $("#aceptarTerminos:checked").val();

	if($("#signatureparent").jSignature("isModified")){

		var firma = $("#signatureparent").jSignature("getData", "image/svg+xml");

	}

	/*=============================================
	VALIDAR
	=============================================*/
	if( nombre == "" ||
		email == "" ||
		patrocinador == "" ||
		enlace_afiliado == "" ||
		pais == "" ||
		codigo_pais == "" ||
		telefono_movil == "" ||
		red == "" ||
		aceptarTerminos != "on" ||
		!$("#signatureparent").jSignature('isModified')){

			$(".suscribirse").before(`

				<div class="alert alert-danger">Faltan datos, no ha aceptado o no ha firmado los términos y condiciones</div>


			`);

		return;


	}else{

		console.log("formulario listo");
	}
	

})