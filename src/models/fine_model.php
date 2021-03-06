<?php
	class Fine {
		function setId($id) {
			$this->id = $id;
		}

		function setDt($dt) {
			$this->dt = $dt;
		}

		function setUserId($userId) {
			$this->userId = $userId;
		}

		function setOwnerId($ownerId) {
			$this->ownerId = $ownerId;
		}

		function setCamId($cameraId) {
			$this->camId = $cameraId;
		}

		function getUserId($name) {
			global $mysqli;
			$db_strings = $mysqli->query("SELECT userId FROM Db_users WHERE name = '$name'");
			$result = $db_strings->fetch_all(MYSQLI_ASSOC);

			if (empty($result)) {
				exit('Похоже, такого пользователя ещё нет!');
			} else {
				foreach ($result as $row) {
					$res = $row['userId'];
				}
				return $res;
			}
		}

		function getOwnerId($reg) {
			global $mysqli;
			$db_strings = $mysqli->query("SELECT cardId FROM Vehicle_owners WHERE carReg = '$reg'");
			$result = $db_strings->fetch_all(MYSQLI_ASSOC);

			if (empty($result)) {
				exit('Похоже, такого владельца ещё нет!');
			} else {
				foreach ($result as $row) {
					$res = $row['cardId'];
				}
				return $res;
			}
		}
		
		function output($flag, $sort_sql) {
			global $mysqli;

			$sort_list = array(
				'fineId_asc' => '`fineId`',
				'fineId_desc' => '`fineId` DESC',
				'datetime_asc' => '`datetime`',
				'datetime_desc' => '`datetime` DESC',
				'userId_asc' => '`userId`',
				'userId_desc' => '`userId` DESC',
				'ownerId_asc' => '`ownerId`',
				'ownerId_desc' => '`ownerId` DESC',
				'cameraId_asc' => '`cameraId`',
				'cameraId_desc' => '`cameraId` DESC'
			);

			$sort = @$_GET['sort'];
			if (array_key_exists($sort, $sort_list)) {
				$sort_sql = $sort_list[$sort];
			} else $sort_sql = reset($sort_list);

			switch ($flag) {
				case 'a':
					$db_strings = $mysqli->query("SELECT * FROM Fines ORDER BY $sort_sql");
					$rows = $db_strings->fetch_all(MYSQLI_ASSOC);
					if (empty($rows)) {
						echo 'Похоже, штрафов ещё нет!';
					} else {
						echo '<table><tr><th>';
						echo sort_link_th('ID штрафа', 'fineId_asc', 'fineId_desc');
						echo '</th><th>Время выписки</th><th>Номер юзера</th><th>Паспорт водителя</th><th>Номер камеры</th></tr>';
						foreach ($rows as $row) {
							echo '<tr><td>'.$row['fineId'].'</td>';
							echo '<td>'.$row['datetime'].'</td>';
							echo '<td>'.$row['userId'].'</td>';
							echo '<td>'.$row['ownerId'].'</td>';
							echo '<td>'.$row['cameraId'].'</td>';
							if ($_SESSION['prv'] == 'admin') {
								echo "<td><a href='/settings/fine_setting.php?fineId=".$row['fineId']."&datetime=".$row['datetime']."&userId=".$row['userId']."&ownerId=".$row['ownerId']."&cameraId=".$row['cameraId']."'>Настроить</a></td>";
							}
							echo '</tr>';
						}
						echo '</table>';
					}
					break;
				case 'o':
					if (isset($_GET['fineId'])) {
						$this->setId($_GET['fineId']);
						$this->setDt($_GET['datetime']);
						$this->setUserId($_GET['userId']);
						$this->setOwnerId($_GET['ownerId']);
						$this->setCamId($_GET['cameraId']);

						echo '<table><tr><th>ID штрафа</th><th>Время выписки</th><th>Номер юзера</th><th>Паспорт водителя</th><th>Номер камеры</th></tr>';
						echo '<td>'.$this->id.'</td>';
						echo '<td>'.$this->dt.'</td>';
						echo '<td>'.$this->userId.'</td>';
						echo '<td>'.$this->ownerId.'</td>';
						echo '<td>'.$this->camId.'</td></table>';
					} else echo 'Выберите штраф';
					break;
			}
		}

		function addFine($camId, $userId, $dt, $ownerId) {
			global $mysqli;
			$result = $mysqli->query("INSERT Fines (datetime, userId, ownerId, cameraId) VALUES ('$dt', '$userId', '$ownerId', '$camId')");

			if ($result) {
				$this->setDt($dt);
				$this->setUserId($userId);
				$this->setOwnerId($ownerId);
				$this->setCamId($cameraId);
				echo '<br>Вы успешно добавили штраф! Обновление страницы...';
				echo '<meta http-equiv="refresh" content="1; url=/views/fines_view.php">';
			}
		}

		function deleteFine() {
			global $mysqli;
			$result = $mysqli->query("DELETE FROM Fines WHERE fineId = '$this->id'");

			if ($result) {
				echo '<br>Информация о штрафе была успешно удалена! Обновление страницы...';
				echo '<meta http-equiv="refresh" content="1; url=/views/fines_view.php">';
			} else exit('Извините, не удалось удалить информацию о факте');
		}
	}