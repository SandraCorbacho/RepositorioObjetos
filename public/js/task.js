
$( document ).ready(function() {
   
    $('#addTask').click(function(){
      
        $('#addForm').attr('style','display:flex')
    })
    $('.closeform').click(function(){
       
        $('#deleteForm').attr('style','display:none');
        $('#addForm').attr('style','display:none');
        $('#editForm').attr('style','display:none');
        

    })
    $('.deleteTask').click(function(){
        let fila = $(this).parent().parent();
        let idTask = ($(fila[0]['cells'][0]).text());
        let description = ($(fila[0]['cells'][1]).text());
        $('#idTask').val(idTask);
        $('#description').text(description);
        $('#deleteForm').attr('style','display:flex');
    })
    $('.editTask').click(function(){
        let fila = $(this).parent().parent();
       
        $('#editIdItem').val($(fila[0]['cells'][0]).text());
        $('#editItemName').val($(fila[0]['cells'][1]).text());
        $('#editDescription').val($(fila[0]['cells'][2]).text());
        $('#editStart_date').val($(fila[0]['cells'][5]).text());
        $('#editFinish_date').val($(fila[0]['cells'][6]).text());
        $('#editForm').attr('style','display:flex');

    })
    $('.addsubtarea').click(function(){
        let fila = $(this).parent().parent();
        $('#subtareaIdItem').val($(fila[0]['cells'][0]).text());
        $('#subtareaForm').attr('style','display:flex');
      
    });
    $('.uncomplete').click(function(){
        let fila = $(this).parent();
        id = $(fila[0]['cells'][0]).text();
        $(this).removeClass('uncomplete');
        $(this).addClass('complete');
        $('#idCompleted').val(id);
        if( $('#idCompleted').val()!= ''){
            $('#completed').submit()
        }
    
               
    })
    
    
})