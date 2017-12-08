{extends 'layout.tpl'}
{block name=content}

    <div class="row">
        <div class="col-md-6" id="codigo">
            <h3 class="text-center">Código</h3>
            <textarea id="code" name="code">{$code}</textarea>
        </div>
        <div class="col-md-6" id="teste">
            <h3 class="text-center">Teste unitário</h3>
            <textarea id="testCode" name="testCode">{$testCode}</textarea>
        </div>
    </div>
    <div class="text-center" style="margin-top: 15px;">
        <button id="executar" name="executar" class="btn btn-primary">Executar</button>
    </div>


    <h3 class="text-center">Saída do PHPUnit</h3>

    <textarea id="phpUnitOutput" name="phpUnitOutput">Clique em executar...</textarea>
    <br/>
{/block}
