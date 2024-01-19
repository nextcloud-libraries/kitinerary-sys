<?php

declare(strict_types=1);

/**
 * @copyright 2022 Côme Chilliet <come.chilliet@nextcloud.com>
 *
 * @author Côme Chilliet <come.chilliet@nextcloud.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace Nextcloud\KItinerary\Sys\Tests\Unit;

require_once __DIR__ . '/../src/SysAdapter.php';

use Nextcloud\KItinerary\Sys\SysAdapter;
use PHPUnit\Framework\TestCase;

class SysAdapterTest extends TestCase {
	private SysAdapter $adapter;
	/* Copied from test files of kitinerary itself */
	private string $testString = 'i0CVXXX007123456789121101/01/1970FRXYTFRMPL0432131/070123456789012345678                DOE               JOHN2CF000          00000';

	protected function setUp(): void {
		parent::setUp();
		$this->adapter = new SysAdapter();
	}

	public function testExtractFromString(): void {
		$data = $this->adapter->extractFromString($this->testString);
		$data = $data[0];
		$this->assertEquals('TrainReservation', $data['@type']);
		$this->assertEquals('JOHN DOE', $data['underName']['name']);
	}

	public function testExtractIcalFromString(): void {
		$data = $this->adapter->extractIcalFromString($this->testString);
		$this->assertContains(
			'LOCATION:FRXYT', array_map('trim', explode("\n", $data))
		);
	}
}
