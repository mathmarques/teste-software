{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Relatório de Confirmados</h3><br/><br/>
    <p class="text-center">Total de pessoas CONFIRMADAS: {count($pessoas)}</p><br/><br/>

    <table class="table table-striped table-hover">
        <tr>
            <th>#</th>
            <th>Identificação</th>
            <th>Email</th>
            <th>Nome</th>
            <th>Nº de Atividades</th>
        </tr>
        {foreach $pessoas as $index => $pessoa}
            <tr>
                <td>{$index+1}</td>
                {if empty($pessoa['matricula'])}
                    <td>{$pessoa['cpf']}</td>
                    <td>{if isset($emails[$pessoa['cpf']])} {$emails[$pessoa['cpf']]} {else} ??? {/if}</td>
                {else}
                    <td>{$pessoa['matricula']}</td>
                    <td>{if isset($emails[$pessoa['matricula']])} {$emails[$pessoa['matricula']]} {else} ??? {/if}</td>
                {/if}
                <td>{$pessoa['nome_pessoa']}</td>
                <td>{count($pessoa['atividades'])}</td>
            </tr>
            {foreachelse}
            <tr>
                <td colspan="5"><h4 class="text-center">Nada encontrado!</h4></td>
            </tr>
        {/foreach}

    </table>
{/block}
