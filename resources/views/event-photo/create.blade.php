@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
@stop

@section('content')

<div class="card text-center" style="background-color: beige">
    <div class="card-header">
        <h1><strong>Subir fotos del evento</strong></h1>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
            
                    <form action="{{ route('event.gallery.store',$event) }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                        @csrf
                        <div>
                            <h4>Suba o arrastre sus fotos aqui</h4>
                        </div>
                    </form>
                    <input id="price" name="price" type="number" class="form-control" required placeholder="Ingrese el precio (Bs)" {{-- value="5.00" --}}>
                    <div class="buttonSubmit">
                        <button id="buttonSubmitE" type="button" style="background-color: rgb(183, 255, 201);font-size: 18px; padding: 10px 20px; border-radius: 20px;margin-top: 20px;"><strong>Subir Imagenes</strong></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
      
    </div>
  </div>




    

@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@stop

@section('js')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
  
    Dropzone.autoDiscover = false;

    var dropzone = new Dropzone('#image-upload', {
          thumbnailWidth: 200,
          maxFilesize: 5,
          maxFiles: 20,
          acceptedFiles: ".jpeg,.jpg,.png,.gif",
          autoProcessQueue: false,
          addRemoveLinks: true,
          sending: function (file, xhr, formData) {
             var inputValue = document.getElementById('price').value;
             formData.append('price', inputValue);
          }
        });
    
    document.getElementById("buttonSubmitE").addEventListener("click", function () {
        dropzone.processQueue();
    });

    dropzone.on("complete", function(file) {
        if (dropzone.getQueuedFiles().length > 0) {
            dropzone.processQueue();
            console.log('Subiendo...');
        } else {
            setTimeout(() => {
                dropzone.removeAllFiles()
            }, 1000);
        }
    });

</script>
@stop
