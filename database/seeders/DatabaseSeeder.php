<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\CemeteryLot;
use App\Models\CemeterySection;
use App\Models\Client;
use App\Models\CollectorAssignment;
use App\Models\DeceasedRecord;
use App\Models\MemorialPage;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage users', 'manage lots', 'manage clients', 'manage billing',
            'collect payments', 'view reports', 'guard terminal', 'collector mobile',
            'moderate memorials', 'approve reservations',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        foreach ([
            'Semi Admin' => $permissions,
            'Cashier' => ['manage billing', 'collect payments', 'view reports'],
            'Staff' => ['manage clients', 'view reports'],
            'Guard' => ['guard terminal'],
            'Collector' => ['collector mobile', 'collect payments'],
            'Family' => [],
        ] as $roleName => $rolePermissions) {
            Role::firstOrCreate(['name' => $roleName])->syncPermissions($rolePermissions);
        }

        $users = collect([
            ['Semi Admin', 'Semi Admin', 'admin@cemeteryms.test'],
            ['Cashier', 'Cashier', 'cashier@cemeteryms.test'],
            ['Records Staff', 'Staff', 'staff@cemeteryms.test'],
            ['Gate Guard', 'Guard', 'guard@cemeteryms.test'],
            ['Mobile Collector', 'Collector', 'collector@cemeteryms.test'],
        ])->map(function ($row) {
            [$name, $role, $email] = $row;
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $name,
                'phone' => '09'.random_int(100000000, 999999999),
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole($role);

            return $user;
        });

        $garden = CemeterySection::firstOrCreate(['code' => 'GA'], [
            'name' => 'Garden of Ascension',
            'description' => 'Premium family lawn section',
            'boundary_polygon' => [[8.16500, 125.99000], [8.16530, 125.99000], [8.16530, 125.99035], [8.16500, 125.99035]],
            'color' => '#4A5C6A',
        ]);

        $heritage = CemeterySection::firstOrCreate(['code' => 'HM'], [
            'name' => 'Heritage Mausoleum',
            'description' => 'Above-ground memorial lots',
            'boundary_polygon' => [[8.16535, 125.99000], [8.16565, 125.99000], [8.16565, 125.99035], [8.16535, 125.99035]],
            'color' => '#9BA8AB',
        ]);

        $clients = collect([
            ['CL-20260518-001', 'Maria', 'Santos', '09171234567'],
            ['CL-20260518-002', 'Jose', 'Reyes', '09181234567'],
            ['CL-20260518-003', 'Ana', 'Dela Cruz', '09191234567'],
        ])->map(fn ($row) => Client::firstOrCreate(['client_number' => $row[0]], [
            'first_name' => $row[1],
            'last_name' => $row[2],
            'phone' => $row[3],
            'email' => Str::slug($row[1].'.'.$row[2]).'@example.test',
            'address' => 'Trento, Agusan del Sur',
            'qr_token' => Str::random(48),
            'qr_issued_at' => now(),
            'portal_enabled' => true,
        ]));

        foreach (range(1, 12) as $index) {
            $client = $index <= $clients->count() ? $clients[$index - 1] : null;
            $lot = CemeteryLot::firstOrCreate([
                'cemetery_section_id' => $index <= 6 ? $garden->id : $heritage->id,
                'lot_number' => 'L-'.str_pad((string) $index, 3, '0', STR_PAD_LEFT),
            ], [
                'client_id' => $client?->id,
                'block' => $index <= 6 ? 'A' : 'B',
                'area_sqm' => 6.25,
                'price' => 35000,
                'status' => $client ? 'occupied' : ($index === 6 ? 'reserved' : 'vacant'),
                'polygon' => [
                    [8.16500 + ($index * .00002), 125.99000],
                    [8.16501 + ($index * .00002), 125.99005],
                    [8.16505 + ($index * .00002), 125.99005],
                    [8.16504 + ($index * .00002), 125.99000],
                ],
            ]);

            if (! $client) {
                continue;
            }

            $billing = Billing::firstOrCreate(['billing_number' => 'BIL-20260518-00'.$index], [
                'client_id' => $client->id,
                'cemetery_lot_id' => $lot->id,
                'type' => 'lot',
                'description' => 'Lot acquisition and maintenance billing',
                'amount' => 35000,
                'paid_amount' => $index === 1 ? 10000 : 0,
                'balance' => $index === 1 ? 25000 : 35000,
                'due_date' => now()->addDays(30),
                'status' => $index === 1 ? 'partial' : 'pending',
            ]);

            if ($index === 1) {
                Payment::firstOrCreate(['reference_number' => 'PAY-20260518-0001'], [
                    'billing_id' => $billing->id,
                    'client_id' => $client->id,
                    'collected_by' => $users->firstWhere('email', 'cashier@cemeteryms.test')?->id,
                    'amount' => 10000,
                    'payment_type' => 'cash',
                    'channel' => 'cashier',
                    'status' => 'posted',
                    'paid_at' => now(),
                ]);
            }

            $deceased = DeceasedRecord::firstOrCreate(['client_id' => $client->id, 'cemetery_lot_id' => $lot->id], [
                'first_name' => 'Memorial',
                'last_name' => $client->last_name,
                'birth_date' => now()->subYears(75),
                'death_date' => now()->subYears(1),
                'interment_date' => now()->subMonths(11),
                'biography' => 'A lovingly maintained memorial record.',
                'privacy' => 'family',
            ]);

            MemorialPage::firstOrCreate(['deceased_record_id' => $deceased->id], [
                'slug' => Str::slug($deceased->first_name.'-'.$deceased->last_name.'-'.$client->client_number),
                'title' => 'In Memory of '.$deceased->first_name.' '.$deceased->last_name,
                'biography' => $deceased->biography,
                'privacy' => 'family',
                'is_published' => true,
                'published_at' => now(),
            ]);
        }

        Reservation::firstOrCreate(['reservation_number' => 'RES-20260518-001'], [
            'cemetery_lot_id' => CemeteryLot::where('status', 'reserved')->first()?->id ?? CemeteryLot::first()->id,
            'applicant_name' => 'Elena Cruz',
            'applicant_email' => 'elena@example.test',
            'applicant_phone' => '09161234567',
            'status' => 'pending',
            'scheduled_at' => now()->addWeek(),
            'requirements' => ['valid_id' => 'pending', 'application_form' => 'uploaded'],
        ]);

        CollectorAssignment::firstOrCreate([
            'collector_id' => $users->firstWhere('email', 'collector@cemeteryms.test')?->id,
            'client_id' => $clients->first()?->id,
            'assigned_date' => today(),
        ], ['status' => 'assigned']);
    }
}
