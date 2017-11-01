{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Relatório de Inscritos</h3><br/><br/>
    <p class="text-center">Total de pessoas inscritas: {$pessoasTotais}</p><br/><br/>

    <table class="table table-striped table-hover">
        <tr>
            <th>Nome</th>
            <th>Nº inscritos</th>
            <th>Nº confirmados</th>
            <th></th>
        </tr>
        {foreach $atividades as $atividade}
            <tr>
                <td>{$atividade['atividade']}</td>
                <td>{$atividade['inscritos']}</td>
                <td>{count($atividade['confirmados'])}</td>
                <td class="text-center">
                    <a href="{path_for name="relatorioDetalhe" data=["id" => $atividade['idAtividade']]}"><span class="glyphicon glyphicon-th-list"></span></a>
                </td>
            </tr>
            {foreachelse}
            <tr>
                <td colspan="4"><h4 class="text-center">Nada encontrado!</h4></td>
            </tr>
        {/foreach}

    </table>
{/block}
