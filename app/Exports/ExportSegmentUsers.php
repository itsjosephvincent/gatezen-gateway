<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSegmentUsers implements FromCollection, ShouldAutoSize, WithHeadings
{
    public function collection(): \Illuminate\Support\Collection
    {
        return DB::table('segment_users')
            ->select(
                'segments.name as segment_name',
                DB::raw('CONCAT_WS(" ", users.firstname, users.lastname) as name'),
                'users.email as email',
                DB::raw('GROUP_CONCAT(DISTINCT roles.name) AS role'),
                DB::raw("GROUP_CONCAT(DISTINCT JSON_UNQUOTE(JSON_EXTRACT(tags.name, '$.en'))) AS tags"),
                'languages.name as language',
                DB::raw('a.balance as cwisc'),
                DB::raw('b.balance as cwiop'),
                DB::raw('c.balance as oddsprofitt'),
                DB::raw('d.balance as thesis'),
                DB::raw('e.balance as `abcb-a`'),
                DB::raw('f.balance as `abcb-b`'),
                DB::raw('g.balance as `aqwt-a`'),
                DB::raw('h.balance as `aqwt-b`'),
                DB::raw('i.balance as nvia'),
                DB::raw('j.balance as `vesg-a`'),
                DB::raw('k.balance as `vesg-b`'),
                DB::raw('l.balance as `gbmt-uk`'),
                DB::raw('m.balance as `gbmt-cy`'),
                DB::raw('n.balance as exim'),
                DB::raw('o.balance as `rpah-a`'),
                DB::raw('p.balance as `rpah-b`'),
                DB::raw('q.balance as `rpah-c`'),
                DB::raw('r.balance as `rpah-d`'),
                DB::raw('s.balance as `rpah-t`'),
                DB::raw('t.balance as `rgi-a`'),
                DB::raw('u.balance as `rgi-b`'),
                DB::raw('v.balance as `redc-a`'),
                DB::raw('w.balance as `redc-b`'),
                DB::raw('x.balance as rhr'),
                DB::raw('y.balance as tgos'),
                DB::raw('z.balance as cmfst'),
            )
            ->leftJoin('users', 'users.id', '=', 'segment_users.user_id')
            ->leftJoin('segments', 'segments.id', '=', 'segment_users.segment_id')
            ->leftJoin('taggables', 'taggables.taggable_id', '=', 'users.id')
            ->leftJoin('tags', 'tags.id', '=', 'taggables.tag_id')
            ->leftJoin('languages', 'languages.id', '=', 'users.language_id')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->leftJoin('wallets as a', function ($join): void {
                $join->on('a.holdable_id', '=', 'users.id')
                    ->where('a.belongable_type', '=', 'App\Models\Ticker')
                    ->where('a.belongable_id', '=', 1);
            })
            ->leftJoin('wallets as b', function ($join): void {
                $join->on('b.holdable_id', '=', 'users.id')
                    ->where('b.belongable_type', '=', 'App\Models\Ticker')
                    ->where('b.belongable_id', '=', 2);
            })
            ->leftJoin('wallets as c', function ($join): void {
                $join->on('c.holdable_id', '=', 'users.id')
                    ->where('c.belongable_type', '=', 'App\Models\Ticker')
                    ->where('c.belongable_id', '=', 3);
            })
            ->leftJoin('wallets as d', function ($join): void {
                $join->on('d.holdable_id', '=', 'users.id')
                    ->where('d.belongable_type', '=', 'App\Models\Ticker')
                    ->where('d.belongable_id', '=', 4);
            })
            ->leftJoin('wallets as e', function ($join): void {
                $join->on('e.holdable_id', '=', 'users.id')
                    ->where('e.belongable_type', '=', 'App\Models\Ticker')
                    ->where('e.belongable_id', '=', 5);
            })
            ->leftJoin('wallets as f', function ($join): void {
                $join->on('f.holdable_id', '=', 'users.id')
                    ->where('f.belongable_type', '=', 'App\Models\Ticker')
                    ->where('f.belongable_id', '=', 6);
            })
            ->leftJoin('wallets as g', function ($join): void {
                $join->on('g.holdable_id', '=', 'users.id')
                    ->where('g.belongable_type', '=', 'App\Models\Ticker')
                    ->where('g.belongable_id', '=', 7);
            })
            ->leftJoin('wallets as h', function ($join): void {
                $join->on('h.holdable_id', '=', 'users.id')
                    ->where('h.belongable_type', '=', 'App\Models\Ticker')
                    ->where('h.belongable_id', '=', 8);
            })
            ->leftJoin('wallets as i', function ($join): void {
                $join->on('i.holdable_id', '=', 'users.id')
                    ->where('i.belongable_type', '=', 'App\Models\Ticker')
                    ->where('i.belongable_id', '=', 9);
            })
            ->leftJoin('wallets as j', function ($join): void {
                $join->on('j.holdable_id', '=', 'users.id')
                    ->where('j.belongable_type', '=', 'App\Models\Ticker')
                    ->where('j.belongable_id', '=', 10);
            })
            ->leftJoin('wallets as k', function ($join): void {
                $join->on('k.holdable_id', '=', 'users.id')
                    ->where('k.belongable_type', '=', 'App\Models\Ticker')
                    ->where('k.belongable_id', '=', 11);
            })
            ->leftJoin('wallets as l', function ($join): void {
                $join->on('l.holdable_id', '=', 'users.id')
                    ->where('l.belongable_type', '=', 'App\Models\Ticker')
                    ->where('l.belongable_id', '=', 12);
            })
            ->leftJoin('wallets as m', function ($join): void {
                $join->on('m.holdable_id', '=', 'users.id')
                    ->where('m.belongable_type', '=', 'App\Models\Ticker')
                    ->where('m.belongable_id', '=', 13);
            })
            ->leftJoin('wallets as n', function ($join): void {
                $join->on('n.holdable_id', '=', 'users.id')
                    ->where('n.belongable_type', '=', 'App\Models\Ticker')
                    ->where('n.belongable_id', '=', 14);
            })
            ->leftJoin('wallets as o', function ($join): void {
                $join->on('o.holdable_id', '=', 'users.id')
                    ->where('o.belongable_type', '=', 'App\Models\Ticker')
                    ->where('o.belongable_id', '=', 15);
            })
            ->leftJoin('wallets as p', function ($join): void {
                $join->on('p.holdable_id', '=', 'users.id')
                    ->where('p.belongable_type', '=', 'App\Models\Ticker')
                    ->where('p.belongable_id', '=', 16);
            })
            ->leftJoin('wallets as q', function ($join): void {
                $join->on('q.holdable_id', '=', 'users.id')
                    ->where('q.belongable_type', '=', 'App\Models\Ticker')
                    ->where('q.belongable_id', '=', 17);
            })
            ->leftJoin('wallets as r', function ($join): void {
                $join->on('r.holdable_id', '=', 'users.id')
                    ->where('r.belongable_type', '=', 'App\Models\Ticker')
                    ->where('r.belongable_id', '=', 18);
            })
            ->leftJoin('wallets as s', function ($join): void {
                $join->on('s.holdable_id', '=', 'users.id')
                    ->where('s.belongable_type', '=', 'App\Models\Ticker')
                    ->where('s.belongable_id', '=', 19);
            })
            ->leftJoin('wallets as t', function ($join): void {
                $join->on('t.holdable_id', '=', 'users.id')
                    ->where('t.belongable_type', '=', 'App\Models\Ticker')
                    ->where('t.belongable_id', '=', 20);
            })
            ->leftJoin('wallets as u', function ($join): void {
                $join->on('u.holdable_id', '=', 'users.id')
                    ->where('u.belongable_type', '=', 'App\Models\Ticker')
                    ->where('u.belongable_id', '=', 21);
            })
            ->leftJoin('wallets as v', function ($join): void {
                $join->on('v.holdable_id', '=', 'users.id')
                    ->where('v.belongable_type', '=', 'App\Models\Ticker')
                    ->where('v.belongable_id', '=', 22);
            })
            ->leftJoin('wallets as w', function ($join): void {
                $join->on('w.holdable_id', '=', 'users.id')
                    ->where('w.belongable_type', '=', 'App\Models\Ticker')
                    ->where('w.belongable_id', '=', 23);
            })
            ->leftJoin('wallets as x', function ($join): void {
                $join->on('x.holdable_id', '=', 'users.id')
                    ->where('x.belongable_type', '=', 'App\Models\Ticker')
                    ->where('x.belongable_id', '=', 24);
            })
            ->leftJoin('wallets as y', function ($join): void {
                $join->on('y.holdable_id', '=', 'users.id')
                    ->where('y.belongable_type', '=', 'App\Models\Ticker')
                    ->where('y.belongable_id', '=', 25);
            })
            ->leftJoin('wallets as z', function ($join): void {
                $join->on('z.holdable_id', '=', 'users.id')
                    ->where('z.belongable_type', '=', 'App\Models\Ticker')
                    ->where('z.belongable_id', '=', 26);
            })
            ->where('taggables.taggable_type', 'App\Models\User')
            ->groupBy(
                'segment_name',
                'name',
                'email',
                'language',
                'cwisc',
                'cwiop',
                'oddsprofitt',
                'thesis',
                'abcb-a',
                'abcb-b',
                'aqwt-a',
                'aqwt-b',
                'nvia',
                'vesg-a',
                'vesg-b',
                'gbmt-uk',
                'gbmt-cy',
                'exim',
                'rpah-a',
                'rpah-b',
                'rpah-c',
                'rpah-d',
                'rpah-t',
                'rgi-a',
                'rgi-b',
                'redc-a',
                'redc-b',
                'rhr',
                'tgos',
                'cmfst',
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Segment name',
            'Name',
            'Email',
            'Role',
            'Tags',
            'Language',
            'CWI Spot Convertable',
            'CWI Ordinary',
            'Oddsprofitt',
            'Thesis',
            'ABC Biotech - Class-A',
            'ABC Biotech - Class-B',
            'AQUA H2O - Class A',
            'AQUA H2O - Class B',
            'NVI Asian Bridge, Class-A',
            'Volver Zen, Class-A',
            'Volver Zen, Class-B',
            'GBMT UK - Class A',
            'GBMT CY - Class A',
            'Global Trading EXIM',
            'REES Property - Class-A',
            'REES Property - Class-B',
            'REES Property - Class-C',
            'REES Property - Class-D',
            'REES Property - Token',
            'REES Global - Class-A',
            'REES Global - Class-B',
            'REES D&C - Class-A',
            'REES D&C - Class-B',
            'REES Hotel & Resorts - Class-A, Class-B',
            'TGI e-Commerce - Class-B',
            'Crymonet Financial Merger Services',
        ];
    }
}
