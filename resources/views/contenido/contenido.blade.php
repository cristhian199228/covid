@extends('principal')
    @section('contenido')
    
    @if(Auth::check())
            @if (Auth::user()->idrol == 1)
            <template v-if="menu==0">
                <pago :ruta="ruta"></pago>
            </template>
            <template v-if="menu==1">
                <revisionpruebas :ruta="ruta"></revisionpruebas>
            </template>
         
            @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==1">
                <ayuda :ruta="ruta"></ayuda>
            </template>
            <template v-if="menu==0">
                <venta :ruta="ruta"></venta>
            </template>
          
            @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==0">
                <auto :ruta="ruta"></auto>
            </template>
           
            @elseif (Auth::user()->idrol == 4)
            <template v-if="menu==0">
                <categoria :ruta="ruta"></categoria>
            </template>
            <template v-if="menu==1">
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>
            <template v-if="menu==9">
                <consultaingreso :ruta="ruta"></consultaingreso>
            </template>
            <template v-if="menu==11">
                <ayuda></ayuda>
            </template>

            <template v-if="menu==12">
                <acerca></acerca>
            </template>
            <template v-if="menu==15">
                <auto :ruta="ruta"></auto>
            </template>
            @else

            @endif

    @endif
       
        
    @endsection