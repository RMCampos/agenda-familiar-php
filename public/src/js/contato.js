if ($('#contatoPage').length > 0) {
    "use strict";
    var main = function() {
        carregarTodas();
    };
    
    function carregarTodas() {
        $.getJSON('https://api.github.com/repos/rmcampos/rjanivers/issues?state=all', function(data) {
            if (data.length > 0) {
                for (var i=0; i<data.length; i++) {
                    var issue = data[i];
                    criarHtml(issue, $('#tbody1'));
                }
                $('#tblIssue').dataTable();
            }
        });
    }
    
    function criarHtml(issue, destino) {
        var modelo =
                '<tr>' +
                '<td class="col-sm-2">' + issue.number + '</td>' +
                '<td class="col-sm-6">' + issue.title + '</td>' +
                '<td class="col-sm-2 hidden-xs">' + issue.labels[0].name + '</td>' +
                '<td class="col-sm-2 hidden-xs">' + issue.state + '</td>' +
                '<td class="col-sm-2 hidden-xs"><a href="' + issue.html_url + '" target="_blank">Link</a></td>' +
                '</tr>';
        destino.append(modelo);
    }

    $(document).ready(main);
}