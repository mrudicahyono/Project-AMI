<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Table</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        th, td {
            border: 1px solid black;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .UMRAH {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
            height: 40px;
        }

        .No-002-KKA-02A {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .BORANG-AUDIT-MUTU-INTERNAL {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            font-weight: bold;
        }

        .table-container {
            padding: 0;
            margin: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="table-container">
        <table>
            <tr>
                <th rowspan="2" style="width: 10%;">
                    <img src="<?= htmlspecialchars($image_path) ?>" alt="Logo" width="50" height="50">
                </th>
                <th style="width: 60%;" class="UMRAH">
                    UNIVERSITAS MARITIM RAJA ALI HAJI
                </th>
                <th rowspan="2" style="width: 30%;" class="No-002-KKA-02A">
                    No: 002-KKA-02A
                </th>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" class="BORANG-AUDIT-MUTU-INTERNAL">
                    BORANG AUDIT MUTU INTERNAL
                    <br> Ringkasan Temuan Audit
                </td>
            </tr>
        </table>
    </div>

    <div class="table-container">
        <table>
            <tr style="background-color: #F2F2F2;">
                <th colspan="5" style="text-align: start; width: 70%;">Audit</th>
                <th colspan="2" style="width: 30%;">Kriteria</th>
            </tr>
            <tr>
                <td colspan="5"></td>
                <?php if (!empty($ringkasanTemuan)) : ?>
                    <td colspan="2">
                        <ol>
                            <?php foreach ($ringkasanTemuan as $value) : ?>
                                <li><?= htmlspecialchars($value['kode_kriteria']) ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                <?php endif; ?>
            </tr>
            <tr style="background-color: #F2F2F2;">
                <td colspan="2" style="width: 33%;">Lokasi</td>
                <td colspan="2" style="width: 37%;">Ruang Lingkup</td>
                <td colspan="2" style="width: 30%;">Tanggal Audit</td>
            </tr>
            <tr>
                <?php if (!empty($dataKopKelengkapanDokumen)) : ?>
                    <td colspan="2"><?= htmlspecialchars($dataKopKelengkapanDokumen['lokasi']) ?></td>
                    <td colspan="2"><?= htmlspecialchars($dataKopKelengkapanDokumen['ruang_lingkup']) ?></td>
                    <td colspan="2"><?= htmlspecialchars($dataKopKelengkapanDokumen['tanggal_audit']) ?></td>
                <?php endif; ?>
            </tr>
            <tr style="background-color: #F2F2F2;">
                <td colspan="2" style="width: 33%;">Wakil Auditi</td>
                <td colspan="2" style="width: 37%;">Auditor Ketua</td>
                <td colspan="2" style="width: 30%;">Auditor Anggota</td>
            </tr>
            <tr>
                <td colspan="2"><?= htmlspecialchars($dataKopKelengkapanDokumen['wakil_auditi']) ?></td>
                <td colspan="2"><?= htmlspecialchars($dataKopKelengkapanDokumen['auditor_ketua']) ?></td>
                <td colspan="2">
                    <ol>
                        <?php foreach ($anggota as $value) : ?>
                            <li><?= htmlspecialchars($value) ?></li>
                        <?php endforeach; ?>
                    </ol>
                </td>
            </tr>
            <tr style="background-color: #F2F2F2;">
                <td style="width: 40%;">Distribusi</td>
                <td style="width: 10%;">Auditi</td>
                <td style="width: 5%;">x</td>
                <td style="width: 10%;">Auditor</td>
                <td style="width: 5%;">0</td>
                <td style="width: 10%;">LPM</td>
                <td style="width: 5%;">X</td>
                <td style="width: 10%;">Arsip</td>
                <td style="width: 5%;">X</td>
            </tr>
            <tr>
                <th style="width: 10%;">Kode Kriteria</th>
                <th style="width: 10%;">No</th>
                <th style="width: 65%;">Deskripsi Temuan</th>
                <th style="width: 15%;">Kategori (OB/KTS)</th>
            </tr>
            <?php $no = 1; ?>
            <?php if (!empty($ringkasanTemuan)) : ?>
                <?php foreach ($ringkasanTemuan as $value) : ?>
                    <tr>
                        <td><?= htmlspecialchars($value['kode_kriteria']) ?></td>
                        <td><?= $no++; ?></td>
                        <td style="text-align: start;"><?= htmlspecialchars($value['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($value['kategori']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>

    <div class="table-container">
        <table>
            <tr style="background-color: #F2F2F2;">
                <th colspan="5" style="height: 30px; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    Tempat Persetujuan
                </th>
            </tr>
            <tr>
                <td style="background-color: #F2F2F2; width: 13%; height: 50px; text-align: start; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    Pimpinan Audit
                </td>
                <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    <div></div>
                    <?= htmlspecialchars($dataKopKelengkapanDokumen['wakil_auditi']) ?>
                    <div></div>
                </td>
                <td></td>
                <td style="background-color: #F2F2F2; width: 10%; height: 50px; text-align: start; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    Ketua Auditor
                </td>
                <td style="font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    <div></div>
                    <?= htmlspecialchars($dataKopKelengkapanDokumen['auditor_ketua']) ?>
                    <div></div>
                </td>
                <td></td>
            </tr>
            <tr style="background-color: #F2F2F2;">
                <td colspan="5" style="height: 30px; width: 100%; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    Direview oleh:
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 20%; height: 50px; background-color: #F2F2F2; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    Penjamin Mutu Audit
                </td>
                <td colspan="2" style="width: 40%; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                    <div></div>
                    <?= htmlspecialchars($periode['penjaminan_mutu_audit']) ?>
                    <div></div>
                </td>
                <td colspan="2" style="width: 40%;"></td>
            </tr>
        </table>
    </div>

</body>

</html>
