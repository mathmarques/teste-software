{extends 'layout.tpl'}
{block name=content}
    {if isset($error)}
        <h3 class="text-center">Erro ao confirmar inscrição!</h3>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">&times;</button>
            <strong>Erro!</strong>
            <p>{$error}</p>
        </div>
    {else}
        <h3 class="text-center">Inscrição confirmada com sucesso!</h3>
        <p class="text-center" style="color:red">ATENÇÃO! As incrições em minicursos estão sujeitas a um limite! A confirmação chegará por e-mail depois.</p>
    {/if}
    <p class="text-center"><a href="{path_for name="confirmar"}">Voltar a página inicial</a></p>
{/block}