@extends('adminlte::page')

@section('title', 'Vehiculos')

@section('content_header')
    <h1 class="m-0 text-dark">Vehiculos</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <form>
            <div class="card p-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Codigo Producto</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="CD31231">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre de Producto</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Filtro para motor">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Categoria</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="cat">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Precio de Venta</label>
                    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="30">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Precio de Compra</label>
                    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="10">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Cant. Disponible</label>
                    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="20">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Imagen</label>
                    <input type="file" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Descripcion</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@stop