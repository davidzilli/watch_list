$(document).ready(function () {

	/*When a user has logged in, his movie selections
	will be pulled from the sql database. PHP will
	generate the movie list. Movies which are added or
	removed from the list can be handled with jQuery to
	prevent having to reload the page every time. PHP
	will keep the database up to date.*/

	//create paging for divs
	$('.nav a').on('click', function(e){
	    e.preventDefault();
	    var nextPage = $(e.target.hash);
	    $("#pages .current").removeClass("current");
	    nextPage.addClass("current");
	});

	//functions for adding a movie to the watch list
	/*
	$('#savemovie a').on('click', function(e){
		var title = $('#titleInput').val();
		movieList.push(title);
		movieListObj = JSON.stringify(movieList);
		//localStorage.movieList(movieListObj);
		$('#addnew input').attr('checked', false);
		$('#titleInput').val('');
		$('#movielist>ul').prepend('<li><a href="" class = "title">' + title + '</a><ul style ="display:none;"><li>TEST</li></ul></li>');
	});
*/
	//Function to expand and hide movie link list
	//initially hide all link lists
	$('#movielist ul li ul').hide();

	//apply toggle to expand list of matches for each title
	$('#movielist').on('click', 'a.title', function(e) {
    	e.preventDefault();
		$(this).next('ul').toggle();
	});

	//Displays an error message for the login screen
	$(function() {
		$('h4.alert').hide().fadeIn(700);
		$('<span class="exit"></span>').appendTo('h4.alert');
	
		$('span.exit').click(function() {
		$(this).parent('h4.alert').fadeOut('slow');						   
		});
	});

}); //end ready
