
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
        let description = ($(fila[0]['cells'][2]).text());
        $('#idTask').val(idTask);
        $('#description').text(description);
        $('#deleteForm').attr('style','display:flex');
    })
    $('.editTask').click(function(){
        let fila = $(this).parent().parent();
        //<label for="itemName">Nombre de la Tarea</label>
        //<input type="text" name='editItemName' required>
        //<label for="description">Descripción de la tarea</label>
        //<textarea type="text" name='editDescription' required> </textarea>
        //<label for="start_date">Fecha de inicio</label>
        //<input type="date" name='editStart_date' required >
        //<label for="finish_date">Fecha de fin</label>
        //<input type="date" name='editFinish_date' required >
        //<input type="submit" value='Guardat Cambios'>
        //let ItemName = ;
        $('#editIdItem').val($(fila[0]['cells'][0]).text());
        $('#editItemName').val($(fila[0]['cells'][2]).text());
        $('#editDescription').val($(fila[0]['cells'][3]).text());
        $('#editStart_date').val($(fila[0]['cells'][5]).text());
        $('#editFinish_date').val($(fila[0]['cells'][6]).text());
        $('#editForm').attr('style','display:flex');

    })
    console.log(Date());
})