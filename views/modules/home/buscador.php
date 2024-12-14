<div class="row row-header" id="consultaOtros" style="display: none; margin-top: -3px;">
    <div class="col-xs-12 col-sm-2 row-searcher" style="color: #fff;">
        <a href="app/index.php" class="btn btn-searcher" style="background-color: #215a9a; color: #fff; width: 100%;">
            Iniciar sesión
        </a>
    </div>
    <div class="col-xs-12 col-sm-5 row-searcher" style="color: #fff;">
        <a href="https://goo.gl/forms/xutNc9NyHrRKGjF02" target="_blank" 
           class="btn btn-searcher" style="background-color: #215a9a; color: #fff; width: 100%;color:#fff;">
            ¿Qué otros indicadores te gustaría consultar?
        </a>
    </div>
    <div class="col-xs-12 col-sm-5 row-searcher">
        <form class="form-inline" action="javascript:buscarIndicador();" style="float: right; width: 100%;">
            <div class="form-group form-searcher">
                <input id="buscarIndicadorText" class="input-searcher" name="buscarIndicadorText" placeholder="Ingrese el nombre del indicador a buscar" type="text" value="" onkeyup="contarCaracteres();" onkeydown="contarCaracteres();" />
                <button class="btn btn-searcher" style="background-color: #215a9a;"><i class="fa fa-search" style="color: #fff;"></i></button>
            </div>
            <div class="form-group">
            </div>
        </form>
    </div>
    <script>
        function contarCaracteres() {
            var param = document.getElementById("buscarIndicadorText").value;
            if (param.length < 3) {
                $("#error-contar-caracteres").show();
            } else {
                $("#error-contar-caracteres").hide();
            }
        }
        function buscarIndicador() {
            var param = document.getElementById("buscarIndicadorText").value;
            if (param.length < 3) {
                alert('Debe ingresar como mínimo 3 caracteres, para realizar la búsqueda.');
            } else {
                $("#error-contar-caracteres").hide();
                window.location.href = "/buscar/" + param;
            }
        }
    </script>
</div>