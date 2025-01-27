function limpiaSnackBar()
{
	jQuery("#snackbar").removeClass("ok");
	jQuery("#snackbar").removeClass("error");
	jQuery("#snackbar").removeClass("chat");
}
function lanzaSnackBar(tipo, mensaje)
{
	jQuery("#snackbar").html(mensaje);
	limpiaSnackBar();
	jQuery("#snackbar").addClass(tipo);
	jQuery("#snackbar").addClass("show");
	setTimeout(function(){ jQuery("#snackbar").removeClass("show")}, 3000);
}
function lanzaSnackBaryRedirecciona(tipo, mensaje, url)
{
	jQuery("#snackbar").html(mensaje);
	limpiaSnackBar();
	jQuery("#snackbar").addClass(tipo);
	jQuery("#snackbar").addClass("show");
	setTimeout(function()
	{ 
		jQuery("#snackbar").removeClass("show");
		window.location.href = url;
	}, 3000);
}
function cambiaDisable(elemento, valor) {
	console.log("Cambio disable: " + elemento + " : " + valor);
	jQuery(elemento).prop('disabled', valor);
}
function reseteaSelect2(idelemento,valor)
{
	jQuery("#"+idelemento+" option").each(function () {jQuery(this).removeAttr('selected');});
	jQuery("#"+idelemento+" option[value='"+valor+"']").attr('selected', 'selected'); 
	jQuery("#"+idelemento).val(valor);
	jQuery("#"+idelemento).trigger('change');
}
function reseteaBusqueda(form_selector) {
    // Determinar el formulario objetivo
    let form_objetivo = form_selector != "" ? form_selector : 'form-filtros-variedades';
    
    // Resetear selects
    reseteaSelect2('select-especie', 0);
    reseteaSelect2('select-empresa', 0);
	// Resetear selects buscador avanzado
    reseteaSelect2('clasificacion1', 0);
    reseteaSelect2('clasificacion2', 0);
	reseteaSelect2('clasificacion3', 0);
	reseteaSelect2('clasificacion4', 0);

    // Resetear checkboxes
    jQuery('input.checkbox-nice').prop('checked', false);

    // Limpiar inputs de texto
    jQuery('#txt-nombre').val('');

    // Obtener el formulario objetivo
    var form = document.getElementById(form_objetivo);
    
    // Verificar si el formulario existe antes de enviarlo
	if (form) {
        form.submit(); // Enviar el formulario
    } else {
        console.error('Formulario no encontrado: ' + form_objetivo);
    }
}
function corchetesArray(corchetes)
{
	var devolver = corchetes;
	devolver = devolver.slice(1, -1); // quitar primer [ y ultimo ]
	devolver = devolver.split(',');
	return devolver;
}
function corchetesLinea(corchetes)
{
	var devolver = corchetes;
	devolver = devolver.slice(1, -1); // quitar primer [ y ultimo ]
	return devolver;
}
function cambiarVista(vista)
{
	jQuery('#valor-modo-vista').val(vista);
	jQuery("#form-filtros-ventas").submit();
}

function dameDatosEnfermedad(idenf)
{
	jQuery.ajax({
		url: AjaxJKY.ajaxurl,
		data: {action: 'dameDatosEnfermedadPorId',id:idenf},
		success: function(response)
		{
			// Rellenar campos
			jQuery("#ver-enfermedad-label").text(response[0]);
			jQuery("#enf-nombre-cientifico").text(response[1]);
			jQuery("#enf-nombre-ingles").text(response[2]);
			jQuery("#enf-codigo").text(response[3]);
			jQuery("#enf-descripcion").html(response[4]);
			
			jQuery("#ver-enfermedad").modal("show");
		}
	});
}

function dameDatosEmpresa(idenf)
{
	// console.log("AKI: "+idenf);
	jQuery.ajax({
		url: AjaxJKY.ajaxurl,
		data: {action: 'dameDatosEmpresaPorId',id:idenf},
		success: function(response)
		{
			// Rellenar campos
			jQuery("#ver-empresa-label").text(response[0]);
			jQuery("#logo_foto_empresa").attr('src', response[1]);
			jQuery("#descripcion").html(response[2]);
			jQuery("#ver-empresa").modal("show");
		}
	});
}

function dameImagenAmpliada(url)
{
	jQuery("#imagen_ampliada").attr('src', url.src);
	jQuery("#ver-imagen").modal("show");
}

function navegarEntreClasiicaciones(select)
{
	// console.log("SELECT: "+select.value);
	// Redirigir a la opción seleccionada
    window.location.href = select.value;
}

jQuery(document).ready(function()
{
	jQuery('.posible-select2').select2({width: 'resolve',placeholder: "Elige una opción"});
	// jQuery(".select-familia").on("select2:open", function(){jQuery(".select2-search__field").focus();});
	cambiaDisable("#clasificacion2", true);
	cambiaDisable("#clasificacion3", true);
	cambiaDisable("#clasificacion4", true);
	
	jQuery('#slider-empresas').slick({
		arrows:			true,
		dots:			false,
		autoplay: 		true,
		autoplaySpeed: 	5000,
		infinite: 		true,
		slidesToShow: 	7,
		slidesToScroll: 2,
		responsive: [
		{
			
			breakpoint: 480,
			settings: {
				slidesToShow: 	2,
				slidesToScroll:	2,
				variableWidth:	false
		  	}
		}
	  ]
	});

	jQuery('.columna.variedad-fotografía div').slick({
		arrows:			true,
		dots:			false,
		autoplay: 		true,
		autoplaySpeed: 	5000,
		infinite: 		true,
		slidesToShow: 	1,
		slidesToScroll: 1,
	});
});