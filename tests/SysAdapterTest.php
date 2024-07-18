<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2022 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
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
