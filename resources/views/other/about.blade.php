@extends('layouts.master')

@section('content')
<h1>About</h1>
<h2>API functionality</h2>
<p>This api stores rock climbing routes. Information that can be stored is the name of the route, description, route length, route rating, location, gear needed. When a new route is added it can be specified as public or not. If a route is public anyone may edit the route, and it cannot be deleted. If a route is private only the person who added the route can edit edit or delete the route. Users must create a profile to create, edit, or remove climbs; however, anyone may view climbs-public or not. For all api requests use headers: Content-Type:application/json and X-Requested-With: XMLHttpRequest</p>

<h3>Creating a user account</h3>
<p>URL: website/api/v1/register<br>Method: Post<br>Required fields are email, password and name. Passwords must be a minimum of 5 characters.</p>

<h3>Signing In</h3>
<p>URL: website/api/v1/signin<br>Method: Post<br>Once a user has created an account they must sign in to recieve a json web token to complete calls that require authentication (creating, editing, or deleting climbs). This token will expire after 2 hours. <br>Required fields to sign in are email and password.</p>

<h3>Creating a climb</h3>
<p>URL: website/api/v1/climbs?token=<insert token from signin here> or website/api/v1/climbs and pass token as a parameter<br>Method: Post<br>Required fields are name, description, rating, location, public, and type. Name must also be less than 255 characters while type must be one of the following: "Top Rope", "Trad", "Sport", or "Boulder". Public is a boolean with 0 representing not a public climb and 1 representing a public climb. Other fields are gear_needed and length. Length is in feet and must be an integer. </p>

<h3>Editing a climb</h3>
<p>URL: website/api/v1/climbs/<insert climb id here>?token=<insert token from signin here> or website/api/v1/climb/<insert climb id here> and pass token as a parameter<br>Method: Patch<br>Editable fields are name, length, rating, type, gear_needed, and location. Name must be less than 255 characters, and length must be an integer. Type must be one of the following: "Top Rope", "Trad", "Sport", or "Boulder".Name, description, rating, type and location cannot be blank.</p>

<h3>Deleting a Climb</h3>
<p>URL: website/api/v1/climbs/<insert climb id here>?token=<insert token from signin here> or website/api/v1/climb/<insert climb id here> and pass token as a parameter<br>Method: Delete<br></p>

<h3>View All Climbs</h3>
<p>URL: website/api/v1/climbs <br>Method: Get<br></p>

<h3>View Climb</h3>
<p>URL: website/api/v1/climbs/<insert climb id here> <br>Method: Get<br></p>
@endsection