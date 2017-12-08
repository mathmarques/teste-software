$(function() {

    var codeEditor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-php",
        indentUnit: 4,
        indentWithTabs: true
    });

    var testCodeEditor = CodeMirror.fromTextArea(document.getElementById("testCode"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-php",
        indentUnit: 4,
        indentWithTabs: true
    });

    var phpUnitEditor = CodeMirror.fromTextArea(document.getElementById("phpUnitOutput"), {
        lineNumbers: true,
        mode: "text/plain",
        indentUnit: 4,
        readOnly: true
    });

    var executando = false;

    $( "#executar" ).click(function() {
        if(executando === true)
            return;

        executando = true;
        $( this ).html('Executando...');
        var self = this;

        $.ajax({
            method: "POST",
            url: "api/process",
            data: { code: codeEditor.getDoc().getValue(), testCode: testCodeEditor.getDoc().getValue() },
            dataType: "json"
        }).done(function(response) {
            console.log(response);

            phpUnitEditor.getDoc().setValue(response.phpunit.output);

            var codeLines = [];
            $("#codigo .CodeMirror-linenumber").each(function (i, e) {
                var line = parseInt(e.innerHTML);
                codeLines[line] = $(e).parent("div").parent("div")[0];
            });

            $.each(codeLines, function(index, value) {
                if(response.phpunit.clover[index] !== undefined) {
                    if (response.phpunit.clover[index] > 0)
                        $(codeLines[index]).css('background-color', 'rgba(0, 250, 23, 0.23)');
                    else
                        $(codeLines[index]).css('background-color', 'rgba(250, 27, 15, 0.19)');
                } else {
                    $(codeLines[index]).css('background-color', 'rgba(250, 250, 250, 0.0)');
                }
            });

        }).fail(function() {
            alert( "Um erro aconteceu..." );
        }).always(function() {
            executando = false;
            $( self ).html('Executar');
        });
    });

});