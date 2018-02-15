<?php

use Illuminate\Database\Seeder;
use App\Filter;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filters = [
            [ 'name' => 'Desserts', 'type' => 'course'],
            [ 'name' => 'Side Dishes', 'type' => 'course'],
            [ 'name' => 'Lunch and Snacks', 'type' => 'course'],
            [ 'name' => 'Appetizers', 'type' => 'course'],
            [ 'name' => 'Salads', 'type' => 'course'],
            [ 'name' => 'Breads', 'type' => 'course'],
            [ 'name' => 'Breakfast and Brunch', 'type' => 'course'],
            [ 'name' => 'Soups', 'type' => 'course'],
            [ 'name' => 'Beverages', 'type' => 'course'],
            [ 'name' => 'Condiments and Sauces', 'type' => 'course'],
            [ 'name' => 'Cocktails', 'type' => 'course'],
            [ 'name' => 'Christmas', 'type' => 'holiday'],
            [ 'name' => 'New Year', 'type' => 'holiday'],
            [ 'name' => 'Easter', 'type' => 'holiday'],
            [ 'name' => 'Valentines\'s Day', 'type' => 'holiday'],
            [ 'name' => 'Thanksgiving', 'type' => 'holiday'],
            [ 'name' => 'Halloween', 'type' => 'holiday'],
            [ 'name' => 'Hanukkah', 'type' => 'holiday'],
            [ 'name' => 'Chinese New Year', 'type' => 'holiday'],
            [ 'name' => 'St. Patrick\'s Day', 'type' => 'holiday'],
            [ 'name' => '4th of July', 'type' => 'holiday'],
            [ 'name' => 'Super Bowl / Game Day', 'type' => 'holiday'],
            [ 'name' => 'Summer', 'type' => 'holiday'],
            [ 'name' => 'Fall', 'type' => 'holiday'],
            [ 'name' => 'Spring', 'type' => 'holiday'],
            [ 'name' => 'Winter', 'type' => 'holiday'],
            [ 'name' => 'American', 'type' => 'cuisine'],
            [ 'name' => 'Italian', 'type' => 'cuisine'],
            [ 'name' => 'Asian', 'type' => 'cuisine'],
            [ 'name' => 'Mexican', 'type' => 'cuisine'],
            [ 'name' => 'Southern & Soul Food', 'type' => 'cuisine'],
            [ 'name' => 'French', 'type' => 'cuisine'],
            [ 'name' => 'Southwestern', 'type' => 'cuisine'],
            [ 'name' => 'Barbecue', 'type' => 'cuisine'],
            [ 'name' => 'Indian', 'type' => 'cuisine'],
            [ 'name' => 'Chinese', 'type' => 'cuisine'],
            [ 'name' => 'Cajun & Creole', 'type' => 'cuisine'],
            [ 'name' => 'English', 'type' => 'cuisine'],
            [ 'name' => 'Mediterranean', 'type' => 'cuisine'],
            [ 'name' => 'Greek', 'type' => 'cuisine'],
            [ 'name' => 'German', 'type' => 'cuisine'],
            [ 'name' => 'Thai', 'type' => 'cuisine'],
            [ 'name' => 'Maroccam', 'type' => 'cuisine'],
            [ 'name' => 'Irish', 'type' => 'cuisine'],
            [ 'name' => 'Japanese', 'type' => 'cuisine'],
            [ 'name' => 'Cuban', 'type' => 'cuisine'],
            [ 'name' => 'Hawaiin', 'type' => 'cuisine'],
            [ 'name' => 'Swedish', 'type' => 'cuisine'],
            [ 'name' => 'Hungarian', 'type' => 'cuisine'],
            [ 'name' => 'Portugese', 'type' => 'cuisine']
        ];

        Filter::insert($filters);
    }
}
