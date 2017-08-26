$(function(){
    $(document).ready(function(){
        if($.datepicker)
        {
            $('.datepicker').datepicker();
            $('.datepicker-multiple').datepicker({ numberOfMonths: 2 });
        }
        
        if($.timepickerbis)
        {
            $('.timepicker').timepicker();
        }
        
        if($.colorpicker)
        {
            $('.colorpicker').colorpicker();
        }
       if($.summernote)
       {
          $('.summernote').summernote({
            height: 200
          });  
       }


        $('.toggle').toggles({
            on: true,
            height: 26
          });   
         
    });
    
});