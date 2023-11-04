/*=============================================
PLUGIN CKEDITOR
=============================================*/
ClassicEditor
.create(document.querySelector("#editor"), {

	toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']

})
.then(function(editor){

	$(".ck-content").css({"height":"200px"})

})
.catch(function(error){
	
	// console.log("error", error);

})

/*=============================================
SUBIENDO ARCHIVOS ADJUNTOS
=============================================*/

$(".subirAdjuntos").change(function(){

	var archivos = this.files;

	for(var i = 0; i < archivos.length; i++){

		/*=============================================
		Validar formatos de archivos
		=============================================*/	

		if( archivos[i]["type"] != "image/jpeg" && 
			archivos[i]["type"] != "image/png" &&
			archivos[i]["type"] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && 
			archivos[i]["type"] != "application/vnd.ms-excel" &&
			archivos[i]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
			archivos[i]["type"] != "application/msword" &&
			archivos[i]["type"] != "application/pdf"){

			$(".subirAdjuntos").val("");

			swal({
	          title: "Error al subir los Archivos",
	          text: "¡El formato de los archivos no es correcto, debe ser: JPG, PNG, EXCEL, WORD o PDF!",
	          type: "error",
	          confirmButtonText: "¡Cerrar!"
	        });

	        return;

		}else if(archivos[i]["size"] > 32000000){

			/*=============================================
			Validar el tamaño de los archivos
			=============================================*/	

			$(".subirAdjuntos").val("");

			swal({
	          title: "Error al subir los Archivos",
	          text: "¡Los Archivos no deben pesar más de 32MB!",
	          type: "error",
	          confirmButtonText: "¡Cerrar!"
	        });

	        return;

		}else{

			multiplesArchivos(archivos[i]);

		}

	}

})

var archivosTemporales = [];

function multiplesArchivos(archivo){

	datosArchivo = new FileReader;
	datosArchivo.readAsDataURL(archivo);

	$(datosArchivo).on("load", function(event){

		var rutaArchivo = event.target.result;   			
		

		if(archivo["type"] == "image/jpeg" || archivo["type"] == "image/png"){

			$(".mailbox-attachments").append(`
	
			<li>
              <span class="mailbox-attachment-icon has-img"><img src="`+rutaArchivo+`" alt="Attachment"></span><br>

              <div class="mailbox-attachment-info">
                <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> `+archivo['name']+`</a>
                    <span class="mailbox-attachment-size clearfix mt-1">
                      <span>`+archivo['size']+` Bytes</span>
                      <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal><i class="fas fa-times"></i></button>
                    </span>
              </div>
            </li>

			`)
		}

		if(archivo["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || archivo["type"] == "application/vnd.ms-excel"){

		 	$(".mailbox-attachments").append(`

		 	 <li>
                  <span class="mailbox-attachment-icon"><i class="far fa-file-excel"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>`+archivo['name']+`</a>
                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>`+archivo['size']+` Bytes</span>
                          <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal><i class="fas fa-times"></i></a>
                        </span>
                  </div>
                </li>

            `);

		}

		if(archivo["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || archivo["type"] == "application/msword"){

		 	$(".mailbox-attachments").append(`

		 	 <li>
                  <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>`+archivo['name']+`</a>
                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>`+archivo['size']+` Bytes</span>
                          <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal><i class="fas fa-times"></i></a>
                        </span>
                  </div>
                </li>

            `);

		}


		if(archivo["type"] == "application/pdf"){

		 	$(".mailbox-attachments").append(`

		 	 <li>
                  <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>`+archivo['name']+`</a>
                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>`+archivo['size']+` Bytes</span>
                          <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal><i class="fas fa-times"></i></a>
                        </span>
                  </div>
                </li>

            `);

		}

		if(archivosTemporales.length != 0){

			archivosTemporales = JSON.parse($(".archivosTemporales").val());

		}

		archivosTemporales.push(rutaArchivo)
		

		$(".archivosTemporales").val(JSON.stringify(archivosTemporales));

	})

}


/*=============================================
Quitar archivo adjunto
=============================================*/

$(document).on("click", ".quitarAdjunto", function(){
	
	var listaTemporales = JSON.parse($(".archivosTemporales").val());

	var quitarAdjunto = $(".quitarAdjunto");

	for(var i = 0; i < listaTemporales.length; i++){

		$(quitarAdjunto[i]).attr("temporal", listaTemporales[i]);

		var quitarArchivo = $(this).attr("temporal");

		if(quitarArchivo == listaTemporales[i]){
			
			listaTemporales.splice(i, 1);

			$(".archivosTemporales").val(JSON.stringify(listaTemporales));

			$(this).parent().parent().parent().remove();

		}

	}


})


