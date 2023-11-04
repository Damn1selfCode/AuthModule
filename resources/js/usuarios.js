/*=============================================
LISTADO DE PAISES
=============================================*/

$.ajax({

	url: "asset('js/plugins/paises.json')",
	type: "GET",
	success: function(respuesta){

		respuesta.forEach(seleccionarPais);

		function seleccionarPais(item, index){

			var pais =  item.name;
			var codPais =  item.code;
			var dial = item.dial_code;

			$("#inputPais").append(

				`<option value="`+pais+`,`+codPais+`,`+dial+`">`+pais+`</option>`

			)


		}

	}

})

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
