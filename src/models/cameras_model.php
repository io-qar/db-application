<?php
	class Camera {
		function setId($id) {
			$this->id = $id;
		}

		function setAddr($address) {
			$this->address = $address;
		}

		function setSetting($setting) {
			$this->setting = $setting;
		}

		function output($flag) {
			global $mysqli;
			switch ($flag) {
				case 'a':
					$db_strings = $mysqli->query("SELECT * FROM Cameras");
					$rows = $db_strings->fetch_all(MYSQLI_ASSOC);	
					
					echo '<table>';
					echo '<tr><th>ID камеры</th><th>Адрес камеры</th><th>Настройка камеры</th></tr>';
					foreach ($rows as $row) {
						echo "<tr>";
						echo "<td>".$row["cameraId"]."</td>";
						echo "<td>".$row["address"]."</td>";
						echo "<td>".$row["setting"]."</td>";
						echo "<td><a href='/settings/camera_setting.php?cameraId=".$row['cameraId']."&address=".$row['address']."&setting=".$row['setting']."'>Настроить</a></td>";
						echo "</tr>";
					}
					echo "</table>";
					break;
				case 'o':
					if (isset($_GET["cameraId"])) {
						$this->setId($_GET["cameraId"]);
						$this->setAddr($_GET["address"]);
						$this->setSetting($_GET["setting"]);

						echo '<table>';
						echo '<tr><th>ID камеры</th><th>Адрес камеры</th><th>Настройка камеры</th></tr>';
						echo "<td>".$this->id."</td>";
						echo "<td>".$this->address."</td>";
						echo "<td>".$this->setting."</td>";
						echo "</table>";
					} else echo 'Выберите камеру';
					break;	
			}
		}

		function changeAddress($newAddr, $id) {
			global $mysqli;
			$result = $mysqli->query("UPDATE Cameras SET address = '$newAddr' WHERE cameraId = $id");

			if ($result) {
				$this->setAddr($newAddr);
				echo "Вы успешно сменили адрес на '$this->address'! Обновление страницы...";
				echo('<meta http-equiv="refresh" content="1; url=/views/cameras_view.php">');
			} else {
				exit("Извините, не удалось сменить адрес на '$newAddr'!");
			}
		}

		function changeSetting($newSetting, $id) {
			global $mysqli;
			// echo $newSetting;
			$result = $mysqli->query("UPDATE Cameras SET setting = '$newSetting' WHERE cameraId = $id");

			if ($result) {
				$this->setSetting($newSetting);
				echo "Вы успешно сменили настройку на '$this->setting'! Обновление страницы...";
				echo('<meta http-equiv="refresh" content="1; url=/views/cameras_view.php">');
			} else {
				exit("Извините, не удалось сменить настройку на '$newSetting'!");
			}
		}
	}