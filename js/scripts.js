/*!
* Start Bootstrap - Freelancer v7.0.5 (https://startbootstrap.com/theme/freelancer)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-freelancer/blob/master/LICENSE)
*/
//
// Scripts
// 

var url_static = document.location.origin+document.location.pathname;


	
$(document).ready(function()
{	
	initPlanetModal();
	initResourceSelectAjax();
	initSelectSearch();
	initCategoryTreeLink();
	initCategoryTreeLinkClose();
	initCategoryTreeLinkLastItem();
	getResourcesCount()

})

function initCategoryTreeLink()
{
	$('.categoryTreeLink').off('click').on('click', function(e){		
		if($(this).hasClass('tree_open'))
			return;		
		level = $(this).data('level');
		id_parent = $(this).data('parent');
		getCategories(level, id_parent);
		
	});
}

function initCategoryTreeLinkClose()
{
	$('a.tree_open').off('click').on('click', function(){		
		
		$(this).next('ul').slideUp(function(){
			$(this).remove();
		});
		$(this).removeClass('tree_open');
		$(this).find('i').removeClass('bi-arrow-down-circle').addClass('bi-arrow-right-circle');
		initCategoryTreeLinkClose();
		initCategoryTreeLink();
	});
}

function initCategoryTreeLinkLastItem()
{
	$('a.type-last-item').off('click').on('click', function(){
		$('i.bi-record-circle').removeClass('bi-record-circle').addClass('bi-circle');
		$(this).find('i').addClass('bi-record-circle');
		id_category = $(this).data('parent');
		
		url = url_static+"controller/controller.php?action=getResources&id_category="+id_category;
		
		$.get({
			  url: url,
			  passive: true,
			  success: function(result){
				  target = "#resourceTable2"
				  setBoostrapTable(target, result) 
			  }
		});
	});
}

function initRedText()
{
	$('.resourceTable  td').each(function(){
		if($(this).html() > 900){
			$(this).addClass('text-red');
		}    	 
	});
}


function initSelectSearch()
{
	$('.select2').select2();
}

function initPlanetModal()
{
	$('#planetModal').on('shown.bs.modal', function (e) {		
		var resource = $(e.relatedTarget).data('bs-resource');
		getPlanets(resource); 
	})
	
	$('#planetModal').on('hide.bs.modal', function (e) {
		$('#planetList li').remove();
	})
}

function getPlanets(resource)
{	
	url = url_static+"controller/controller.php?action=getPlanet&resource="+resource;
	
	$.get({
		url: url,
		passive: true,
		success: function(result){
			$('#planetList li').remove();
			$('#modalResName').html(resource);
			$.each(JSON.parse(result), function(key, value){
				$element = '<li class="list-group-item">'+value+'</li>';
				$('#planetList').append($element).show('slow');;
			});
		}
	});
}

function getCategories(level, id_parent)
{	
	level++;
	url = url_static+"controller/controller.php?action=getCategories&level="+level+"&id_parent="+id_parent;
	
	$.ajax({
		type: 'GET',
		url: url,
		passive: true,
		success: function(result){
			$ul = $('<ul></ul>').addClass('subCategory');
			
			$.each(JSON.parse(result), function(key, value){
			
				var html = "";
				if(value['children'] > 0){
					html += '<i class="bi bi-arrow-right-circle"></i>';
					last_item = false;
				}else{
					html += '<i class="bi bi-circle"></i>';
					last_item = true;
				}
				
				$li = $('<li></li>').addClass('menu_'+value['id_category']);			
				$a = $('<a></a>').addClass('categoryTreeLink')
						   .addClass('categoryTreeLink_'+value['id_category'])
						   .attr('href', 'javascript:void(0);')
						   .data('level', value['level_depth'])
						   .data('parent', value['id_category'])
						   .addClass('level_'+value['level_depth'])
						   .addClass('cat_'+value['id_category'])
						   
				res_counter =  '<span class="res_count" id="res_count_'+value['id_category']+'" data-id_category='+value['id_category']+'></span>';	   
				   
				if(last_item == true){
					$a.addClass('type-last-item').removeClass('categoryTreeLink');
					$a.html(html+value['name']+"  "+res_counter);
				}else{
					$a.html(html+value['name']+"  "+res_counter);
				}
				
				
				$li.append($a);				
				$li.appendTo($ul);
			});

			$ul.appendTo('li.menu_'+id_parent).hide().slideDown();
			$('a.categoryTreeLink_'+id_parent).addClass('tree_open');
			$('a.categoryTreeLink_'+id_parent).find('i').removeClass('bi-arrow-right-circle').addClass('bi-arrow-down-circle');
			
			initCategoryTreeLink();
			initCategoryTreeLinkClose();
			initCategoryTreeLinkLastItem();
			getResourcesCount();
		}
	});
}

function getResourcesCount()
{	
	$('.res_count').each(function(){
		var id_category = $(this).data('id_category');
		$.get({
			url: url_static+"controller/controller.php?action=getResourcesCount&id_category="+id_category,
			success: function(result){
				count = JSON.parse(result);
				if(count == 0){
					$('#res_count_'+id_category).html('('+count+')');	
				}else{
					$('#res_count_'+id_category).html('('+count+' Resource'+(count > 1 ? 's' : '')+')');			
				}
			}
		});
		
	})

}

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            offset: 72,
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});

//deprecated
function initResourceLink()
{	
	 $('.resourceTable tr td:first-child').each(function() {
 	  resName = $(this).find("a").data("name");
 	  
 	  /*html = '<a href="https://galaxyharvester.net/resource.py/118/'+resName+'" target="_blank" class="res-link text-capitalize">'+resName+'</a>'
 	  $(this).html(html);*/
 	  $(this).parent().attr('id', resName);
   });
}

//deprecated
function initPlanets()
{
	 $('.resourceTable tr td:last-child').each(function() {
   	  planet = $(this).parent('tr').attr('id');
   	  html = '<a href="javascript:void(0)" class="planet-button"  data-bs-toggle="modal"  data-bs-resource="'+planet+'" data-bs-target="#planetModal"><i class="fas fa-globe"></i></a>'
		  $(this).html(html).addClass('text-center');
   	  
     });
}

function initResourceSelectAjax()
{
	$('#tableGroupSelect').on("change", function(){
		groupValue = $(this).val();
		
		if(groupValue == 0){
			  $('table').bootstrapTable("destroy");
			  return false;;
		}
		
		url = url_static+"controller/controller.php?action=getGroup&group="+groupValue;
		
		$.get({
			  url: url,
			  passive: true,
			  success: function(result){
				  target = "#resourceTable1"
				  setBoostrapTable(target, result) 
			  }
		});
	});
}

function setBoostrapTable(target, result)
{
	$(target).bootstrapTable("destroy");	  
    $(target).bootstrapTable({
	  	columns: [
	  		{
	  			field: 'name',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'type_name',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'CR',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'CD',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'DR',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'FL',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'HR',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'MA',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'PE',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'OQ',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'SR',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'UT',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'ER',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
	  		{
	  			field: 'enter_date',			    	    
	  			align: 'center',
	  			valign: 'middle',
	  			sortable:true,
	  		},
		        {
		          field: 'planet',			    	    
		          align: 'center',
		          valign: 'middle',
		        },
	  	        ],
	      data: JSON.parse(result),
	    }).bootstrapTable('hideLoading').on('sort.bs.table', function(e, params){
	  	  //not working for now...
	  	  initRedText(); 
	    })
	
	    initRedText();	   
}

