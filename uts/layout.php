<?php
		function getData($data) {
			$kd = substr($data['booking'], 0, 2);
			$lantai = substr($data['booking'], 2, 2);
			$nomor = substr($data['booking'], 4, 3);
			$kamar = [
				'AL' => [
					'name' => 'Alamanda',
					'price' => 450000
				],
				'BG' => [
					'name' => 'Bougenvile',
					'price' => 350000
				],
				'CR' => [
					'name' => 'Crysan',
					'price' => 375000
				],
				'KM' => [
					'name' => 'Kemuning',
					'price' => 425000
				],
			];
			
			$total = $kamar[$kd]['price'];
			$tambahan = 0;
			$kasur = 0;
			if ($data['jumlah'] > 2) {
				$kasur = $data['jumlah'] * 75000;
				$tambahan = $kasur;
			}
			if ($data['payment'] == "Kartu Kredit") {
				$tambahan += ($total + $tambahan) * (2 / 100);
			}elseif ($data['payment'] == "Debit") {
				$tambahan -= ($total + $tambahan) * (1.5 / 100);
			}

			return [
				'name' => $kamar[$kd]['name'],
				'price' => $kamar[$kd]['price'],
				'lantai' => $lantai,
				'nomor' => $nomor,
				'tambahan' => $tambahan,
				'kasur' => $kasur,
				'total' => $total
			];
		}
	?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<h2>Form Input-Output Dengan PHP</h2>
<hr><br>
<!-- Input Form-->
<form action="layout.php" method="post" style="border: 2px solid navy;padding: 10px; width: 55%;">
	<table cellpadding="0" cellspacing="10">
		<tr><u><b>Form Input</b></u></tr>
		<tr>
			<td>Nama </td>
			<td> : </td>
			<td><input type="text" name="nama" required placeholder="ketikkan namamu" style="width: 96%"></td>
			<td style="padding-left: 60px;">Lama</td>
			<td> : </td>
			<td><input type="number" name="lama" required style="width: 40%;">   Hari</td>
		</tr>
		<tr>
			<td>Kode Booking </td>
			<td> : </td>
			<td>
				<select name="booking" style="width: 100%" required>
					<option value="" selected="true" disabled="disabled">----Pilih Kode Booking----</option>
					<option value="AL02102">AL02102</option>
					<option value="BG03025">BG03025</option>
					<option value="CR02111">CR02111</option>
					<option value="KM03075">KM03075</option>
				</select>
			</td>
			<td colspan="3">[ AL02102 | BG03025 | CR02111 | KM03075 ]</td>
		</tr>
		<tr>
			<td>Jumlah Orang </td>
			<td> : </td>
			<td><input type="number" name="jumlah" required style="width: 50%;">   Orang</td>
			<td>Jenis Pembayaran </td>
			<td> : </td>
			<td style="font-size: 12px">
				<select name="payment" style="width: 40%" required>
					<option value="" selected="true" disabled="disabled">--Pilih--</option>
					<option value="Kartu Kredit">Kartu Kredit</option>
					<option value="Debit">Debit</option>
					<option value="Cash">Cash</option>
				</select>
			[Kartu Kredit | Debit | Cash]
			</td>
		</tr>
		<tr>
			<td align="center">
				<button type="submit" name="submit" value="submit" style="width: 100%;">Proses</button>
			</td>
			<td colspan="2">
				<button type="reset" name="delete" value="delete" style="width: 100px;">Hapus</button>
			</td>
			<td colspan="3"></td>
		</tr>
	</table>
	<!-- Output Form-->
	<?php if (isset($_POST['submit'])): ?>
		<?php
			$data = getData($_POST);
		?>
		<div style="border: 2px solid navy;padding-bottom: 30px;padding: 50px;">
			<h1 align="center">FLORENSIA HOTEL</h1>
			<table style="width: 100%;">
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?= $_POST['nama'] ?></td>
					<td></td>
					<td>Kode Booking</td>
					<td>:</td>
					<td><?= $_POST['booking'] ?></td>
				</tr>
				<tr>
					<td>Nama Kamar</td>
					<td>:</td>
					<td><?= $data['name'] ?></td>
					<td></td>
					<td>Lantai</td>
					<td>:</td>
					<td><?= $data['lantai'] ?></td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>:</td>
					<td><?= $data['nomor'] ?></td>
					<td></td>
					<td>Jumlah</td>
					<td>:</td>
					<td><?= $_POST['jumlah'] ?> Orang</td>
				</tr>
				<tr>
					<td>Lama</td>
					<td>:</td>
					<td><?= $_POST['lama'] ?> Hari</td>
					<td></td>
					<td>Jenis Pembayaran</td>
					<td>:</td>
					<td><?= $_POST['payment'] ?></td>
				</tr>
				<tr>
					<td>Potongan / Tambahan</td>
					<td>:</td>
					<td><?= $data['tambahan'] ?></td>
					<td></td>
					<td>Biaya Spring Bad Tambahan</td>
					<td>:</td>
					<td><?= $data['kasur'] ?></td>
				</tr>
				<tr>
					<td>Total Biaya Seluruhnya</td>
					<td>:</td>
					<td>Rp <?= ($data['total'] + $data['tambahan']) * $_POST['lama'] ?></td>
				</tr>
			</table>
	<?php endif ?>
</form>
</body>
</html>