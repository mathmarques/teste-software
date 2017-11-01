{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Relatório detalhado</h3><br/><br/>
    <p class="text-center">Minicurso: {$atividade['atividade']}</p>
    <p class="text-center">Total de pessoas inscritas: {$atividade['inscritos']}</p>
    <p class="text-center">Total de pessoas CONFIRMADAS: {count($atividade['confirmados'])}</p><br/><br/>

    <table class="table table-striped table-hover">
        <tr>
            <th>#</th>
            <th>Identificação</th>
            <th>Email</th>
            <th>Nome</th>
            <th>hora</th>
        </tr>
        {foreach $atividade['confirmados'] as $index => $pessoa}
            <tr>
                <td>{$index+1}</td>
                {if empty($pessoa['matricula'])}
                    <td>{$pessoa['cpf']}</td>
                    <td>{$emails[$pessoa['cpf']]}</td>
                {else}
                    <td>{$pessoa['matricula']}</td>
                    <td>{$emails[$pessoa['matricula']]}</td>
                {/if}
                <td>{$pessoa['nome_pessoa']}</td>
                <td>{$pessoa['time']}</td>
            </tr>
            {foreachelse}
            <tr>
                <td colspan="5"><h4 class="text-center">Nada encontrado!</h4></td>
            </tr>
        {/foreach}

    </table>
{/block}
