<fieldset style="border:solid 1px grey; padding:20px;">
    <legend>Información básica del estudiante</legend>
    <table width="100%">
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
            <td style="text-align:right">
                <b>Valor base matrícula: $1.000.000</b>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
                    <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
                    <input class="form-control" name="nombre" type="text" id="nombre" value="{{ $matricula->nombre or ''}}">
                    {!! $errors->first('nombre', '<p class="help-block" style="color:red;">:message</p>') !!}
                </div>        
            </td>
            <td>
                <div class="form-group {{ $errors->has('documento') ? 'has-error' : ''}}">
                    <label for="documento" class="control-label">{{ 'Documento' }}</label>
                    <input class="form-control" name="documento" type="text" id="documento" value="{{ $matricula->documento or ''}}">
                    {!! $errors->first('documento', '<p class="help-block"  style="color:red;">:message</p>') !!}
                </div>        
            </td>
            <td>
                <div class="form-group {{ $errors->has('edad') ? 'has-error' : ''}}">
                    <label for="edad" class="control-label">{{ 'Edad' }}</label>
                    <input class="form-control" name="edad" type="number" id="edad" value="{{ $matricula->edad or ''}}" >
                    {!! $errors->first('edad', '<p class="help-block" style="color:red;">:message</p>') !!}
                </div>        
            </td>        
        </tr>
        <tr>
            <td>
                <div class="form-group {{ $errors->has('idDepartamento') ? 'has-error' : ''}}">
                    <label for="idDepartamento" class="control-label">{{ 'Departamento' }}</label>
                    <select class="form-control" name="idDepartamento">
                        @foreach ($departamentosArray as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>;
                        @endforeach
                    </select>
                    {!! $errors->first('idDepartamento', '<p class="help-block" style="color:red;">:message</p>') !!}
                </div>
            </td>
            <td>
                <div class="form-group {{ $errors->has('idCiudad') ? 'has-error' : ''}}">
                    <label for="idCiudad" class="control-label">{{ 'Ciudad' }}</label>
                    <select class="form-control" name="idCiudad">
                        @foreach ($ciudadesArray as $ciudad)
                            <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>;
                        @endforeach
                    </select>                                
                    {!! $errors->first('idCiudad', '<p class="help-block" style="color:red;">:message</p>') !!}
                </div>
            </td>
            <td>
                <div class="form-group {{ $errors->has('estrato') ? 'has-error' : ''}}">
                    <label for="estrato" class="control-label">{{ 'Estrato' }}</label>
                    <select name="estrato" class="form-control" id="estrato" >
                        @foreach (json_decode('{"1":"1","2":"2","3":"3","4":"4","5":"5","6":"6"}', true) as $optionKey => $optionValue)
                            <option value="{{ $optionKey }}" {{ (isset($matricula->estrato) && $matricula->estrato == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('estrato', '<p class="help-block" style="color:red;">:message</p>') !!}
                </div>
            </td>        
        </tr>    
    </table>
</fieldset>

<fieldset style="border:solid 1px grey; padding:20px;" id="seccionDescuentoMatricula">
    <legend>Descuento según estrato</legend>
    <table width="100%">
        <tr>
            <td>
                Descuento según estrato <br/>
                Porcentaje descuento <span id="estrato"></span>: <span id="porcentajeDescuentoEstrato">30</span>%
                <input class="form-control" name="valor" type="hidden" id="valor" value="{{ $matricula->valor or ''}}">
            </td>
            <td style="text-align:right">
                &nbsp;<br/>
                <span id="descuento">Descuento $300000</span>
            </td>            
        </tr>
    </table>
</fieldset>

<table width="100%">
    <tr>
        <td>
            &nbsp;
        </td>
        <td style="text-align:right;font-weight:bold;">
            &nbsp;
            Valor total matrícula $<span id="valorTotalMatricula">700000</span>
        </td>            
    </tr>
</table>

<br/>

<div class="form-group">
    <input class="btn btn-primary" name="Guardar" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>

<script type="text/javaScript">
    $(function(){

        let $idDepartamento = $("select[name=idDepartamento]");
        let $idCiudad = $("select[name=idCiudad]");
        let $estrato = $("select[name=estrato]");

        let $valorTotalMatricula = $("#valorTotalMatricula");

        let $seccionDescuentoMatricula = $("#seccionDescuentoMatricula");
        let $porcentajeDescuentoEstrato = $("#porcentajeDescuentoEstrato");
        let $descuento = $("#descuento");

        let $valor = $("input[name=valor]");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $idDepartamento.change(function(){            
            $.post('/ciudad/ciudads/ciudadesByDepartamento', {
                idDepartamento:$idDepartamento.val()
            }, function(ciudadesHTML){                
                $idCiudad.html(ciudadesHTML);
            });
        });

        $estrato.change(function(){

            let valorTotalMatricula = 1000000;

            if(parseInt($estrato.val(), 10) > 3){
                $seccionDescuentoMatricula.slideUp(500);                
            }
            else
            {
                $seccionDescuentoMatricula.slideDown(500);

                let arrayPorcentajeDescuentoEstrato = ["", 30, 20, 10, "", ""];
                let porcentajeDescuentoEstrato = arrayPorcentajeDescuentoEstrato[$estrato.val()];                
                $porcentajeDescuentoEstrato.html(porcentajeDescuentoEstrato);
                
                let descuento = (valorTotalMatricula * (porcentajeDescuentoEstrato/100));
                $descuento.html("Descuento $" + descuento);

                valorTotalMatricula = valorTotalMatricula - descuento;
            }
            
            $valorTotalMatricula.html(valorTotalMatricula);

            $valor.val(valorTotalMatricula);
            
        });        
    });
</script>