
<ul>
    <li>Apis Delta Ltda</li>
    <li>R. Álvares Cabral, nº 1151</li>
    <li>Vila Conceicao, Diadema - SP, 09980-160</li>
    <li>Tel. 11 4056-2300</li>
</ul>
<hr>
<p>PESAGEM AUTOMÁTICA</p>
<hr>
<ul>
    <li>ID: {{ $visitView.id }}</li>
    <li>VEICULO: {{ $car.board }}</li>
    <li>EMPRESA: {{ $visitant.company }}</li>
    <li>MOTORISTA: {{ $visitant.name }}</li>
    <li>TRANSPORTADORA: {{ $visitView.id }}</li>
    <li>FINALIZADA: {{ $visitView.reason }}</li>
    <li>RESPONSÁVEL: {{ $visitView.responsible }}</li>
    <li>OBSERVAÇÕES: {{ $visitView.note }}</li>
    <li></li>
    <li>PRIMEIRA PESAGEM: {{ $balance.input }} KG</li>
    <li>DATA/HORA: {{ $visitView.started }}</li>
    <li></li>
    <li>SEGUNDA PESAGEM: {{ $balance.ending }} KG</li>
    <li>DATA/HORA: {{ $visitView.finished }}</li>
    <li></li>
    <li>PESO LIQUIDO: {{ $balance.difference }} KG</li>
    <li>AÇÃO IDENTIFICADA: {{ $balance.action }}</li>
</ul>