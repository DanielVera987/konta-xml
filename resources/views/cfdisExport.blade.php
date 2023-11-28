<table>
    <thead>
    <tr>
        <th>Version</th>
        <th>Tipo De Comprobante</th>
        <th>Fecha Emision</th>
        <th>Serie</th>
        <th>Folio</th>
        <th>UUID</th>
        <th>RFC Emisor</th>
        <th>Nombre Emisor</th>
        <th>RFC Receptor</th>
        <th>Nombre Receptor</th>
        <th>Uso de CFDI</th>
        <th>Subtotal</th>
        <th>Descuento</th>
        <th>Total IEPS</th>
        <th>IVA 16%</th>
        <th>Retenido IVA</th>
        <th>Retenido ISR</th>
        <th>Total Impuestos Trasladados</th>
        <th>Total Impuestos Retenidos</th>
        {{-- <th>ISH</th> --}}
        <th>Total</th>
        <th>Moneda</th>
        <th>Tipo De Cambio</th>
        <th>Forma de pago</th>
        <th>Metodo de Pago</th>
        <th>Conceptos</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cfdis as $cfdi)
        @php
            $complemento = $cfdi->getNode();
            $emisor = $complemento->searchNode('cfdi:Emisor');
            $receptor = $complemento->searchNode('cfdi:Receptor');
            $conceptos = $complemento->searchNodes('cfdi:Conceptos', 'cfdi:Concepto');
            $impuestos = $complemento->searchNode('cfdi:Impuestos');
            $tfd = $complemento->searchNode('cfdi:Complemento', 'tfd:TimbreFiscalDigital');
            $stringConceptos = '';

            foreach($conceptos as $concepto) {
                $stringConceptos .= $concepto['Descripcion'] . ' * ';
            }

            $tipoDeComprobante = $cfdi->getNode()['TipoDeComprobante'];

            switch ($tipoDeComprobante) {
                case 'I':
                    $tipoDeComprobante = 'Ingreso';
                    break;
                case 'E':
                    $tipoDeComprobante = 'Egreso';
                    break;
                case 'P':
                    $tipoDeComprobante = 'Pago';
                    break;
                default:
                    $tipoDeComprobante = $tipoDeComprobante;
                    break;
            }
        @endphp
        <tr>
            <td>{{ $cfdi->getNode()['Version'] }}</td>
            <td>{{ $tipoDeComprobante }}</td>
            <td>{{ $cfdi->getNode()['Fecha'] }}</td>
            <td>{{ $cfdi->getNode()['Serie'] }}</td>
            <td>{{ $cfdi->getNode()['Folio'] }}</td>
            <th>{{ $tfd['UUID'] ?? '' }}</th>
            <td>{{ $emisor['Rfc'] }}</td>
            <td>{{ $emisor['Nombre'] }}</td>
            <th>{{ $receptor['Rfc'] }}</th>
            <th>{{ $receptor['Nombre'] }}</th>
            <th>{{ $receptor['UsoCFDI'] }}</th>
            <td>{{ $cfdi->getNode()['SubTotal'] }}</td>
            <td>{{ $cfdi->getNode()['Descuento'] }}</td>
            <td>{{ $impuestos['TotalRetencionesIEPS'] ?? '' }}</td>
            <td>{{ $impuestos['TotalTrasladosImpuestoIVA16'] ?? '' }}</td>
            <th>{{ $impuestos['TotalRetencionesIVA'] ?? '' }}</th>
            <th>{{ $impuestos['TotalRetencionesISR'] ?? '' }}</th>
            <th>{{ $impuestos['TotalImpuestosTrasladados'] ?? '' }}</th>
            <th>{{ $impuesots['TotalImpuestosRetenidos'] ?? '' }}</th>
            {{-- <th>ISH</th> --}}
            <td>{{ $cfdi->getNode()['Total'] }}</td>
            <td>{{ $cfdi->getNode()['Moneda'] }}</td>
            <td>{{ $cfdi->getNode()['TipoCambio'] }}</td>
            <td>{{ $cfdi->getNode()['FormaPago'] }}</td>
            <td>{{ $cfdi->getNode()['MetodoPago'] }}</td>
            <th>{{ $stringConceptos }}</th>

        </tr>
    @endforeach
    </tbody>
</table>
