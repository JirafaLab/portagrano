function inputSelectCambia(objeto)
{
	var tipo = objeto.value;
	// console.log(objeto.id+" - "+tipo);
	if(objeto.id == 'clasificacion1') 
	{
		// Averiguar el anterior valor
		

		// limpiar los dos campos clasificacion2 y clasificacion3
		limpiaDatosSelect('clasificacion2');
		limpiaDatosSelect('clasificacion3');
		// rellenar el campo clasificacion2
		if(tipo != "")
		{
			cargaDatosSelect('clasificacion2', tipo);
			cargaDatosSelectEnfermedades(tipo);
			cambiaDisable("#clasificacion2", false)
		}
	}
	else
	{
		if(objeto.id == 'clasificacion2') 
		{
			// limpiar el campo clasificacion3
			limpiaDatosSelect('clasificacion3');
			// rellenar el campo clasificacion2
			if(tipo != "") {
				cargaDatosSelect('clasificacion3', tipo);
				cambiaDisable("#clasificacion3", false)
			}
		}
		else
		{
			if(objeto.id == 'clasificacion3') 
			{
				// limpiar el campo clasificacion3
				limpiaDatosSelect('clasificacion4');
				// rellenar el campo clasificacion2
				if(tipo != "") {
					cargaDatosSelect('clasificacion4', tipo);
					cambiaDisable("#clasificacion4", false)
				}
			}	
		}
	}
	//lanzaSnackBar("ok", "Cargamos datos de nuevo");
}
function inputSelectClasificacion1Cambia(valold, valew, tarea)
{
	if(valew != "")
	{
		if(valold != valew)
		{
			limpiaDatosSelect('clasificacion2');
			cargaDatosSelect('clasificacion2', valew);
			limpiaDatosSelect('clasificacion3');
		}
		cargaDatosSelectEnfermedades(valew);
	}
}


function limpiaDatosSelect(id)
{
	jQuery('#'+id).empty();
}
function cargaDatosSelect(id,padre)
{
	
	jQuery.ajax({
		url: JKY_sf.ajaxurl,
		data: {action: 'jky_dame_opciones_select',cat_padre:padre},
		success: function(response)
		{
			jQuery('#'+id).append(response);
		}
	});
}

function cargaDatosSelectEnfermedades(tipo)
{
	// Accede a su tarea (default: busqueda)
	let tarea = jQuery("#clasificacion1").data('tarea') ? jQuery("#clasificacion1").data('tarea') : 'busqueda';
	jQuery.ajax({
		url: JKY_sf.ajaxurl,
		data: {action: 'jky_dame_opciones_select_enfermedades',tipo, tarea},
		success: function(response)
		{
			//console.log(tarea);
			//console.log(response);
			// Verifica si response está vacío o si sus elementos están vacíos
			if (!response || response.length === 0 || response.every(item => !item)) {
				// Si está vacío, establece el contenido HTML como vacío
				html_vacio = 'No hay enfermedades asociadas a esta especie';
				jQuery('#select-enfermedades-enf_resistencia_alta').html(html_vacio);
				jQuery('#select-enfermedades-enf_resistencia_intermedia').html(html_vacio);
				jQuery('#select-enfermedades-enf_tolerancia').html(html_vacio);
				jQuery('#buscador-variedades-enfermedad').html(html_vacio);
			} else {
				// Si no está vacío, utiliza los valores de response
				if(tarea == "busqueda")
					jQuery('#buscador-variedades-enfermedad').html(response[0]);
				else {
					jQuery('#select-enfermedades-enf_resistencia_alta').html(response[0]);
					jQuery('#select-enfermedades-enf_resistencia_intermedia').html(response[1]);
					jQuery('#select-enfermedades-enf_tolerancia').html(response[2]);
				}
				hazSelect2();
			}
		}
	});
}
function cargaCaracteristicasEspecie(especie)
{
//	console.log("Especie: "+especie);

	jQuery.ajax({
		url: JKY_sf.ajaxurl,
		data: {action: 'jky_dame_opciones_caracteristicas',especie},
		success: function(response)
		{
			// console.log(response)
			jQuery('#buscador-seccion-caracteristicas').html(response);
		}
	});
}


function hazSelect2()
{
	jQuery('.posible-select2').select2({
		placeholder: 'Busca y selecciona una opción',
		width: 'resolve',
		allowClear: true,
		language: {
			noResults: function() {
				return "No se encontraron resultados";
    		}
		}
	});
	// console.log("Hago select2");
}
function addOtroNombre()
{
	var contenido = "<input type='text' class='input-semilla input-txt' name='otro_nombre[]' value='' placeholder='Insertar Nombre' id='otro_nombre[]'>&nbsp;";
	jQuery("#caja-otros-nombres").append(contenido);
	lanzaSnackBar("ok", "Añadiremos otro nombre");
}


jQuery(document).ready(function()
{
	jQuery('#clasificacion1').data('valor-anterior', jQuery('#clasificacion1').val());
	jQuery('#clasificacion1').on('change', function()
	{
		// Accede al valor anterior almacenado en el atributo de datos
		var valold = jQuery(this).data('valor-anterior');
		
		// Actualiza el valor anterior con el valor actual del select
		jQuery(this).data('valor-anterior', jQuery(this).val());
		inputSelectClasificacion1Cambia(valold, jQuery(this).val())
	});
	jQuery('#clasificacion1.select-buscador').on('change', function()
	{
		cargaCaracteristicasEspecie(jQuery('#clasificacion1.select-buscador').val());
		
	});
	
	
	// Function for Preview Image.
    jQuery(function()
    {
    	jQuery(".imagen-semilla").change(function()
    	{
			var cual_imagen = this.id;
			if (this.files && this.files[0])
			{
				var reader = new FileReader();
				reader.onload = function(e) {
					imageIsLoaded(e, cual_imagen);
				};
				reader.readAsDataURL(this.files[0]);
			}
		});
 	}); 
 	function imageIsLoaded(e, cual_imagen)
 	{
		switch(cual_imagen)
		{
			case 'imagen1':
				jQuery('#message_1').css("display", "none");
				jQuery('#preview_1').css("display", "block");
				jQuery('#previewimg_1').attr('src', e.target.result);
				break;
			case 'imagen2':
				jQuery('#message_2').css("display", "none");
				jQuery('#preview_2').css("display", "block");
				jQuery('#previewimg_2').attr('src', e.target.result);
				break;
			case 'imagen3':
				jQuery('#message_3').css("display", "none");
				jQuery('#preview_3').css("display", "block");
				jQuery('#previewimg_3').attr('src', e.target.result);
				break;
			case 'imagen4':
				jQuery('#message_4').css("display", "none");
				jQuery('#preview_4').css("display", "block");
				jQuery('#previewimg_4').attr('src', e.target.result);
				break;
		}
	};
	
	// Function for Displaying Details of Uploaded Image.
	jQuery("#submit").click(function()
	{
		jQuery('#preview_1').css("display", "none");
		jQuery('#message_1').css("display", "block");
		
		jQuery('#preview_2').css("display", "none");
		jQuery('#message_2').css("display", "block");
		
		jQuery('#preview_3').css("display", "none");
		jQuery('#message_3').css("display", "block");
		
		jQuery('#preview_4').css("display", "none");
		jQuery('#message_4').css("display", "block");
	});
});