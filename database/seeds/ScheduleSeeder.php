<?php

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeSlots = [
            [
                'time_slot' => '00:00',
                'time_slot_drop' => '12:00am',
                'time_order'=>'73',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '00:15',
                'time_slot_drop' => '12:15am',
                'time_order'=>'74',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '00:30',
                'time_slot_drop' => '12:30am',
                'time_order'=>'75',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '00:45',
                'time_slot_drop' => '12:45am',
                'time_order'=>'76',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '01:00',
                'time_slot_drop' => '1:00am',
                'time_order'=>'77',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '01:15',
                'time_slot_drop' => '1:15am',
                'time_order'=>'78',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '01:30',
                'time_slot_drop' => '1:30am',
                'time_order'=>'79',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '01:45',
                'time_slot_drop' => '1:45am',
                'time_order'=>'80',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '02:00',
                'time_slot_drop' => '2:00am',
                'time_order'=>'81',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '02:15',
                'time_slot_drop' => '2:15am',
                'time_order'=>'82',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '02:30',
                'time_slot_drop' => '2:30am',
                'time_order'=>'83',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '02:45',
                'time_slot_drop' => '2:45am',
                'time_order'=>'84',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '03:00',
                'time_slot_drop' => '3:00am',
                'time_order'=>'85',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '03:15',
                'time_slot_drop' => '3:15am',
                'time_order'=>'86',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '03:30',
                'time_slot_drop' => '3:30am',
                'time_order'=>'87',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '03:45',
                'time_slot_drop' => '3:45am',
                'time_order'=>'88',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '04:00',
                'time_slot_drop' => '4:00am',
                'time_order'=>'89',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '04:15',
                'time_slot_drop' => '4:15am',
                'time_order'=>'90',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '04:30',
                'time_slot_drop' => '4:30am',
                'time_order'=>'91',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '04:45',
                'time_slot_drop' => '4:45am',
                'time_order'=>'92',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '05:00',
                'time_slot_drop' => '5:00am',
                'time_order'=>'93',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],[
                'time_slot' => '05:15',
                'time_slot_drop' => '5:15am',
                'time_order'=>'94',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '05:30',
                'time_slot_drop' => '5:30am',
                'time_order'=>'95',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '05:45',
                'time_slot_drop' => '5:45am',
                'time_order'=>'96',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '06:00',
                'time_slot_drop' => '6:00am',
                'time_order'=>'1',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],[
                'time_slot' => '06:15',
                'time_slot_drop' => '6:15am',
                'time_order'=>'2',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '06:30',
                'time_slot_drop' => '6:30am',
                'time_order'=>'3',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '06:45',
                'time_slot_drop' => '6:45am',
                'time_order'=>'4',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '07:00',
                'time_slot_drop' => '7:00am',
                'time_order'=>'5',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '07:15',
                'time_slot_drop' => '7:15am',
                'time_order'=>'6',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '07:30',
                'time_slot_drop' => '7:30am',
                'time_order'=>'7',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '07:45',
                'time_slot_drop' => '7:45am',
                'time_order'=>'8',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '08:00',
                'time_slot_drop' => '8:00am',
                'time_order'=>'9',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '08:15',
                'time_slot_drop' => '8:15am',
                'time_order'=>'10',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '08:30',
                'time_slot_drop' => '8:30am',
                'time_order'=>'11',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '08:45',
                'time_slot_drop' => '8:45am',
                'time_order'=>'12',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '09:00',
                'time_slot_drop' => '9:00am',
                'time_order'=>'13',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '09:15',
                'time_slot_drop' => '9:15am',
                'time_order'=>'14',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '09:30',
                'time_slot_drop' => '9:30am',
                'time_order'=>'15',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '09:45',
                'time_slot_drop' => '9:45am',
                'time_order'=>'16',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '10:00',
                'time_slot_drop' => '10:00am',
                'time_order'=>'17',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '10:15',
                'time_slot_drop' => '10:15am',
                'time_order'=>'18',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '10:30',
                'time_slot_drop' => '10:30am',
                'time_order'=>'19',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '10:45',
                'time_slot_drop' => '10:45am',
                'time_order'=>'20',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '11:00',
                'time_slot_drop' => '11:00am',
                'time_order'=>'21',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],[
                'time_slot' => '11:15',
                'time_slot_drop' => '11:15am',
                'time_order'=>'22',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '11:30',
                'time_slot_drop' => '11:30am',
                'time_order'=>'23',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '11:45',
                'time_slot_drop' => '11:45am',
                'time_order'=>'24',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '12:00',
                'time_slot_drop' => '12:00pm',
                'time_order'=>'25',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '12:15',
                'time_slot_drop' => '12:15pm',
                'time_order'=>'26',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '12:30',
                'time_slot_drop' => '12:30pm',
                'time_order'=>'27',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '12:45',
                'time_slot_drop' => '12:45pm',
                'time_order'=>'28',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '13:00',
                'time_slot_drop' => '1:00pm',
                'time_order'=>'29',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ] ,
            [
                'time_slot' => '13:15',
                'time_slot_drop' => '1:15pm',
                'time_order'=>'30',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '13:30',
                'time_slot_drop' => '1:30pm',
                'time_order'=>'31',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '13:45',
                'time_slot_drop' => '1:45pm',
                'time_order'=>'32',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '14:00',
                'time_slot_drop' => '2:00pm',
                'time_order'=>'33',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '14:15',
                'time_slot_drop' => '2:15pm',
                'time_order'=>'34',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '14:30',
                'time_slot_drop' => '2:30pm',
                'time_order'=>'35',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '14:45',
                'time_slot_drop' => '2:45pm',
                'time_order'=>'36',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '15:00',
                'time_slot_drop' => '3:00pm',
                'time_order'=>'37',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '15:15',
                'time_slot_drop' => '3:15pm',
                'time_order'=>'38',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '15:30',
                'time_slot_drop' => '3:30pm',
                'time_order'=>'39',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '15:45',
                'time_slot_drop' => '3:45pm',
                'time_order'=>'40',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '16:00',
                'time_slot_drop' => '4:00pm',
                'time_order'=>'41',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '16:15',
                'time_slot_drop' => '4:15pm',
                'time_order'=>'42',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '16:30',
                'time_slot_drop' => '4:30pm',
                'time_order'=>'43',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '16:45',
                'time_slot_drop' => '4:45pm',
                'time_order'=>'44',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '17:00',
                'time_slot_drop' => '5:00pm',
                'time_order'=>'45',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],[
                'time_slot' => '17:15',
                'time_slot_drop' => '5:15pm',
                'time_order'=>'46',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '17:30',
                'time_slot_drop' => '5:30pm',
                'time_order'=>'47',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '17:45',
                'time_slot_drop' => '5:45pm',
                'time_order'=>'48',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '18:00',
                'time_slot_drop' => '6:00pm',
                'time_order'=>'49',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],[
                'time_slot' => '18:15',
                'time_slot_drop' => '6:15pm',
                'time_order'=>'50',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '18:30',
                'time_slot_drop' => '6:30pm',
                'time_order'=>'51',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '18:45',
                'time_slot_drop' => '6:45pm',
                'time_order'=>'52',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '19:00',
                'time_slot_drop' => '7:00pm',
                'time_order'=>'53',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '19:15',
                'time_slot_drop' => '7:15pm',
                'time_order'=>'54',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '19:30',
                'time_slot_drop' => '7:30pm',
                'time_order'=>'55',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '19:45',
                'time_slot_drop' => '7:45pm',
                'time_order'=>'56',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '20:00',
                'time_slot_drop' => '8:00pm',
                'time_order'=>'57',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '20:15',
                'time_slot_drop' => '8:15pm',
                'time_order'=>'58',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '20:30',
                'time_slot_drop' => '8:30pm',
                'time_order'=>'59',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '20:45',
                'time_slot_drop' => '8:45pm',
                'time_order'=>'60',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '21:00',
                'time_slot_drop' => '9:00pm',
                'time_order'=>'61',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '21:15',
                'time_slot_drop' => '9:15pm',
                'time_order'=>'62',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '21:30',
                'time_slot_drop' => '9:30pm',
                'time_order'=>'63',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '21:45',
                'time_slot_drop' => '9:45pm',
                'time_order'=>'64',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '22:00',
                'time_slot_drop' => '10:00pm',
                'time_order'=>'65',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '22:15',
                'time_slot_drop' => '10:15pm',
                'time_order'=>'66',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '22:30',
                'time_slot_drop' => '10:30pm',
                'time_order'=>'67',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '22:45',
                'time_slot_drop' => '10:45pm',
                'time_order'=>'68',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '23:00',
                'time_slot_drop' => '11:00pm',
                'time_order'=>'69',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '23:15',
                'time_slot_drop' => '11:15pm',
                'time_order'=>'70',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '23:30',
                'time_slot_drop' => '11:30pm',
                'time_order'=>'71',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],
            [
                'time_slot' => '23:45',
                'time_slot_drop' => '11:45pm',
                'time_order'=>'72',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s")
            ],

        ];

        DB::table('time_slots')->insert($timeSlots);

        $data = [];
        for($i = 1; $i < 52; $i++) {
            $data[$i]['name'] = $i;
            $data[$i]['created_at'] =  now();
            $data[$i]['updated_at'] =  now();
        }
        DB::table('weeks')->insert($data);



    }
}
