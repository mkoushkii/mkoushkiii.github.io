//
// کـاربــر تـالار گفتگـوی پـرشـیـن اسکـریـپــت » i PersianScript « فـارسـی و زیـبـــا ! سـازی شـده تـوسـط 
//
// Copyright © 2011 All right reserved By » i PersianScript « the user » forum.persianscript.ir « Forum . 
//
// Powered by FTPLess .
//

$(function(){
	$('.delete').click(function(){
		if ($(this).parent().parent().parent().hasClass('directory')) var name = 'directory';
		else var name = 'file';
		
		return confirm(' آیــا از حــذف ایــن ' + name + ' مـطـمـئــن هـسـتـیـد ؟ ');
	});
	
	$('.list-directory ul').css({ display: 'none' });
	$('.list-directory strong').css({ cursor: 'pointer' }).click(function(){
		var $this = $(this);
		
		$this.siblings('ul').slideToggle();
	});
	
	$('#dir').change(function(){
		window.location = 'index.php?dir=' + $(this).val();
	});
	$('#change').find('input[type=submit]').css('display', 'none');
});