<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Presupuesto <?= $budget->series . '-' . str_pad($budget->number, 4, '0', STR_PAD_LEFT) ?></title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }

        .header-table {
            width: 100%;
            margin-bottom: 40px;
        }

        .logo {
            max-height: 80px;
            max-width: 250px;
        }

        .company-info {
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .client-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #eee;
        }

        .meta-data {
            text-align: right;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table th {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .totals-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .total-row td {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 16px;
            padding-top: 10px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td valign="top">
                <?php
                $logoFullPath = $_SERVER['DOCUMENT_ROOT'] . ($settings->logo_path ?? '');
                if ($settings->logo_path && file_exists($logoFullPath)): ?>
                    <img src="<?= $logoFullPath ?>" class="logo">
                <?php else: ?>
                    <h1 style="margin:0; color: #333; line-height: 1;"><?= h($settings->name ?? 'Agencia Digital') ?></h1>
                <?php endif; ?>
            </td>
            <td valign="top" class="company-info">
                <strong><?= h($settings->name ?? 'Agencia Digital') ?></strong><br>
                <?= h($settings->address ?? '') ?><br>
                <?= h($settings->zip ?? '') ?> <?= h($settings->city ?? '') ?><br>
                CIF: <?= h($settings->tax_id ?? '') ?><br>
                <?= h($settings->email ?? '') ?><br>
                <?= h($settings->phone ?? '') ?>
            </td>
        </tr>
    </table>

    <table class="meta-table">
        <tr>
            <td valign="top" width="50%">
                <div class="client-box">
                    <strong>Cliente:</strong><br>
                    <?= h($budget->project()->client()->name ?? 'Cliente desconocido') ?><br>
                    <?= h($budget->project()->client()->company ?? '') ?><br>
                    <?= h($budget->project()->client()->email ?? '') ?><br>
                    <?= h($budget->project()->client()->phone ?? '') ?>
                </div>
            </td>
            <td valign="top" class="meta-data">
                <div class="invoice-title">PRESUPUESTO</div>
                <div style="font-size: 16px; color: #666; margin-bottom: 15px;">
                    #<?= h($budget->series ?? 'PRE') ?>-<?= str_pad($budget->number ?? 0, 4, '0', STR_PAD_LEFT) ?>
                </div>

                <strong>Fecha:</strong> <?= date('d/m/Y', strtotime($budget->created_at ?? 'now')) ?><br>
                <?php if ($budget->valid_until): ?>
                    <strong>Válido hasta:</strong> <?= date('d/m/Y', strtotime($budget->valid_until)) ?><br>
                <?php endif; ?>
                <strong>Estado:</strong> <?= ucfirst($budget->status ?? 'borrador') ?>
            </td>
        </tr>
    </table>

    <div style="margin-bottom: 20px;">
        <strong>Proyecto:</strong> <?= h($budget->title ?? 'Proyecto General') ?><br>
        <span style="color: #666;"><?= h($budget->description ?? '') ?></span>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th width="50%">Concepto</th>
                <th width="15%" class="text-right">Cantidad</th>
                <th width="15%" class="text-right">Precio Un.</th>
                <th width="20%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <strong><?= h($item->concept ?? '') ?></strong>
                        <?php if (isset($item->description) && $item->description): ?>
                            <br><span style="font-size: 12px; color: #666;"><?= h($item->description) ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right"><?= number_format($item->quantity ?? 0, 2, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($item->unit_price ?? 0, 2, ',', '.') ?> €</td>
                    <td class="text-right"><?= number_format($item->total ?? 0, 2, ',', '.') ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Subtotal</td>
            <td class="text-right"><?= number_format($budget->subtotal ?? 0, 2, ',', '.') ?> €</td>
        </tr>
        <tr>
            <td>IVA (<?= $budget->tax_rate ?? 21 ?>%)</td>
            <td class="text-right">
                <?= number_format(($budget->subtotal ?? 0) * (($budget->tax_rate ?? 21) / 100), 2, ',', '.') ?> €
            </td>
        </tr>
        <?php if ($budget->has_irpf): ?>
            <tr>
                <td>IRPF (<?= $budget->irpf_rate ?? 0 ?>%)</td>
                <td class="text-right">
                    -<?= number_format(($budget->subtotal ?? 0) * (($budget->irpf_rate ?? 0) / 100), 2, ',', '.') ?> €
                </td>
            </tr>
        <?php endif; ?>
        <tr class="total-row">
            <td>TOTAL</td>
            <td class="text-right"><?= number_format($budget->total ?? 0, 2, ',', '.') ?> €</td>
        </tr>
    </table>

    <div class="footer">
        Presupuesto generado digitalmente. Para aceptar este presupuesto, por favor fírmelo y envíelo de vuelta.
        <br><br>
        <?= h($settings->website ?? '') ?>
    </div>

</body>

</html>