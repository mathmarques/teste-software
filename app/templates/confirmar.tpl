{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Confirmação de Inscrição</h3>

    {if !isset($atividades)}
        <div class="login">
            <h4 class="text-center" style="padding-bottom: 10px;">Pesquisar inscrição</h4>
            {if isset($error)}
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-hidden="true">&times;</button>
                    <strong>Erro!</strong>
                    <p>{$error}</p>
                </div>
            {/if}

                <form name="confirmar" method="post" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Matrícula</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="matricula" id="matricula">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button id="confirmar" name="confirmar" type="submit"
                                    class="btn btn-primary">Consultar</button>
                        </div>
                    </div>
                </form>
        </div>
    {else}
        <form name="confirmar" method="post" class="form-horizontal" role="form" action="{path_for name="confirmado"}">
            <input type="hidden" name="cpf" value="{$atividades[0]['cpf']}"/>
            <input type="hidden" name="matricula" value="{$atividades[0]['maricula']}"/>
            <input type="hidden" name="nome_pessoa" value="{$atividades[0]['nome']}"/>
            <div class="form-group">
                <label class="col-sm-3 control-label">Nome</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nome" id="nome" value="{$atividades[0]['nome']}" disabled="disabled">
                </div>
            </div>
            {foreach $atividades as $atividade}
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <input type="checkbox" name="atividades[]" value="{$atividade['idAtividade']}" {if $atividade['confirmado']}checked{/if}> {$atividade['atividade']}
                    </div>
                </div>
            {/foreach}

            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <button id="enviar" name="enviar" type="submit"
                            class="btn btn-primary">Confirmar atividades!
                    </button>
                </div>
            </div>
        </form>
    {/if}

{/block}
