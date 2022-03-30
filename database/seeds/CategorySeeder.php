<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'English',
                'type' => 'Grinds',
            ], [
                'name' => 'Irish',
                'type' => 'Grinds',
            ], [
                'name' => 'Maths',
                'type' => 'Grinds',
            ], [
                'name' => 'History',
                'type' => 'Grinds',
            ], [
                'name' => 'Geography',
                'type' => 'Grinds',
            ], [
                'name' => 'Science',
                'type' => 'Grinds',
            ], [
                'name' => 'Business Studies',
                'type' => 'Grinds',
            ], [
                'name' => 'German',
                'type' => 'Grinds'
            ], [
                'name' => 'French',
                'type' => 'Grinds'
            ], [
                'name' => 'Spanish',
                'type' => 'Grinds',
            ], [
                'name' => 'Italian',
                'type' => 'Grinds',
            ], [
                'name' => 'Greek',
                'type' => 'Grinds',
            ], [
                'name' => 'Engineering',
                'type' => 'Grinds',
            ], [
                'name' => 'Home Economics',
                'type' => 'Grinds',
            ], [
                'name' => 'Technical Graphics',
                'type' => 'Grinds',
            ], [
                'name' => 'Classical Studies',
                'type' => 'Grinds',
            ], [
                'name' => 'Physics',
                'type' => 'Grinds',
            ], [
                'name' => 'Chemistry',
                'type' => 'Grinds',
            ], [
                'name' => 'Biology',
                'type' => 'Grinds',
            ], [
                'name' => 'Accounting',
                'type' => 'Grinds',
            ], [
                'name' => 'Economics',
                'type' => 'Grinds',
            ], [
                'name' => 'Applied Mathematics',
                'type' => 'Grinds',
            ], [
                'name' => 'Computer Science',
                'type' => 'Grinds',
            ], [
                'name' => 'Technology',
                'type' => 'Grinds',
            ], [
                'name' => 'Speech and Language Lessons',
                'type' => 'Grinds',
            ], [
                'name' => 'Occupational Therapy Classes',
                'type' => 'Grinds',
            ], [
                'name' => 'Dyslexia Workshops',
                'type' => 'Grinds',
            ], [
                'name' => 'Touch Typing Classes',
                'type' => 'Grinds',
            ],

            [
                'name' => 'Music',
                'type' => 'Activities',
            ], [
                'name' => 'Sports & Outdoors',
                'type' => 'Activities',

            ],
            [
                'name' => 'Language',
                'type' => 'Activities',
            ],
            [
                'name' => 'Dance/Drama',
                'type' => 'Activities',
            ],
            [
                'name' => 'Arts & Crafts',
                'type' => 'Activities',
            ],
            [
                'name' => 'Computer & Coding',
                'type' => 'Activities',
            ],
            [
                'name' => 'Whats on Now',
                'type' => 'Activities',
            ],[
                'name' => 'Others',
                'type' => 'Activities',
            ]

        ];

        $subCategories = [
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 1],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 1],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 2],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 2],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 3],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 3],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 4],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 4],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 5],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 5],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 6],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 6],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 7],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 8],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 9],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 10],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 11],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 12],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 13],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 14],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 15],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 16],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 17],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 18],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 19],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 20],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 21],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 22],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 23],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 24],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 25],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 25],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 26],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 26],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 27],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 27],
            ['name' => 'Primary School', 'type' => 'Grinds', 'parent_id' => 28],
            ['name' => 'Secondary School', 'type' => 'Grinds', 'parent_id' => 28],
            ['name' => 'Piano', 'type' => 'Activities', 'parent_id' => 29],
            ['name' => 'Guitar', 'type' => 'Activities', 'parent_id' => 29],
            ['name' => 'Violin', 'type' => 'Activities', 'parent_id' => 29],
            ['name' => 'Singing/Voice', 'type' => 'Activities', 'parent_id' => 29],
            ['name' => 'Drums', 'type' => 'Activities', 'parent_id' => 29],
            ['name' => 'Harp', 'type' => 'Activities', 'parent_id' => 29],
            ['name' => 'Swimming', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Horse Riding', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Kayaking', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Sailing', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Scouts', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Athletics', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Gymnastics', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Martial Arts', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Irish', 'type' => 'Activities', 'parent_id' => 31],
            ['name' => 'Spanish', 'type' => 'Activities', 'parent_id' => 31],
            ['name' => 'German', 'type' => 'Activities', 'parent_id' => 31],
            ['name' => 'French', 'type' => 'Activities', 'parent_id' => 31],
            ['name' => 'Italian', 'type' => 'Activities', 'parent_id' => 31],
            ['name' => 'Chinese', 'type' => 'Activities', 'parent_id' => 31],
            ['name' => 'Irish Dancing', 'type' => 'Activities', 'parent_id' => 32],
            ['name' => 'Ballet', 'type' => 'Activities', 'parent_id' => 32],
            ['name' => 'Hip-Hop', 'type' => 'Activities', 'parent_id' => 32],
            ['name' => 'Free Style', 'type' => 'Activities', 'parent_id' => 32],
            ['name' => 'Ballroom Dancing', 'type' => 'Activities', 'parent_id' => 32],
            ['name' => 'Stage School (Drama & Dance)', 'type' => 'Activities', 'parent_id' => 32],
            ['name' => 'Drawing', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Painting', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Pottery', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Decoupage', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Sculpture + Pottery', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Chess', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Cooking', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Typing', 'type' => 'Activities', 'parent_id' => 34],
            ['name' => 'Coding', 'type' => 'Activities', 'parent_id' => 34],
            ['name' => 'Computing', 'type' => 'Activities', 'parent_id' => 34],
            ['name' => 'Halloween Camps', 'type' => 'Activities', 'parent_id' => 35],
            ['name' => 'February Midterm Camps', 'type' => 'Activities', 'parent_id' => 35],
            ['name' => 'Easter Camps', 'type' => 'Activities', 'parent_id' => 35],
            ['name' => 'Summer Camps', 'type' => 'Activities', 'parent_id' => 35],
            ['name' => 'Christmas & Easter Revision Courses for Junior and Leaving Certificate', 'type' => 'Activities', 'parent_id' => 35],

            ['name' => 'Music (General)', 'type' => 'Activities', 'parent_id' => 29],
            ['name' => 'Sports & Outdoors (General)', 'type' => 'Activities', 'parent_id' => 30],
            ['name' => 'Language (General)', 'type' => 'Activities', 'parent_id' => 31],
            ['name' => 'Dance/Drama (General)', 'type' => 'Activities', 'parent_id' => 32],
            ['name' => 'Arts & Crafts (General)', 'type' => 'Activities', 'parent_id' => 33],
            ['name' => 'Computer & Coding (General)', 'type' => 'Activities', 'parent_id' => 34],
            ['name' => 'Whats on Now (General)', 'type' => 'Activities', 'parent_id' => 35],
        ];


        foreach ($categories as $category) {
            try {
                \App\Category::create($category);
            } catch (\Exception $e) {
                dump($e->getMessage());
            }
        }

        foreach ($subCategories as $category) {
            try {
                \App\Category::create($category);
            } catch (\Exception $e) {
                dump($e->getMessage());
            }
        }
    }
}
