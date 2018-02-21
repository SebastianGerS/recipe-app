<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .route-info {
                padding: 5em;
            }
            p {
                text-align: left;
            }
            li {
                list-style: none;
            }
            h2{
                text-align: center;
            }
            ul {
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
            <div class="content">
                <div class="title m-b-md">
                    Recipe and Ingredient Api
                </div>

                <div class="links">
                    <h2> Available Routes</h2>
                    <ul>
                        <li>/api/auth/register</li>
                        <li>/api/auth/login</li>
                        <li>/api/auth/logout</li>
                        <li>/api/auth/refresh</li>
                        <li>/api/auth/lists</li>
                        <li>/api/auth/lists/:listId</li>
                        <li>/api/auth/lists/:listId/ingredients</li>
                        <li>/api/auth/lists/:listId/ingredients/:ingredientId</li>
                        <li>/api/auth/lists/:listId/recipes</li>
                        <li>/api/auth/lists/:listId/recipes/:recipeId</li>
                    </ul>
                </div>
                <div class="route-info">
                    <p> The register, login, logout, and refresh routes all accept post requests.<br>
                        The refresh route (and all other routes requires you to send your token recived upon login)<br><br>
                        <b>/api/auth/lists</b> accepts a get request and returns a collection of all list associated with the token provided<br>
                        and also accepts a post request to gether with two varibles name and type, type has to bw aither recipes or ingredients <br><br>
                        <b>/api/auth/lists/:listId</b> accepts only a delete request and will delete the list with the id given in the route no adisional parameters neaded<br>
                        note that you can only delete lists conected to the provided token.<br><br>
                        <b>/api/auth/lists/:listId/ingredients</b> accepts a post request and expects an variable ingredients contaning an array of strings (one ingredient/index), the strings are expected to start with a number (the amount) folowed by a whitespace then the unit of measurement then whitespace then the name of the ingredient for example:<br>
                        [<br>
                        &nbsp;&nbsp;'1 liter strawberries',<br>
                        &nbsp;&nbsp;'2 scops vanilla iscreem'<br>
                        ]<br>
                        it's possible to send as many ingredients as you wish but note that even if you just send in one ingredient it has to be incapuslated in an array<br><br>
                        <b>/api/auth/lists/:listId/ingredients/:ingredientId</b> accepts a delete request and will delete the ingredient with the matching ingredientId from the list with the matching listId if the ingredient is not conected to any other list or recipe stored in the data bas it will also be deleted from tha database<br><br>
                        <b>/api/auth/lists/:listId/recipes</b> accepts a post request and expects an variable recipe a recipe with the flowing formula <br>
                        {<br>
                        &nbsp;&nbsp;name: string;<br>
                        &nbsp;&nbsp;cuisines: [string];<br>
                        &nbsp;&nbsp;courses: [string];<br>
                        &nbsp;&nbsp;holidays: [string];<br>
                        &nbsp;&nbsp;time: number;<br>
                        &nbsp;&nbsp;ingredients: any[];<br>
                        &nbsp;&nbsp;imgUrl: string;<br>
                        &nbsp;&nbsp;recipeLink: string;<br>
                        }<br>
                        and stores the gicen recipe to the list coresponding with listId in the route<br><br>
                        <b>/api/auth/lists/:listId/recipes/:recipeId</b> accepts get and delete requests, a get request will get the recipe coresponding to the recipeId if it exists int he list coresponding to the listId<br>
                        the delete request will delte the same recipe<br><br>

                        note that no recipes or ingredients are stored in the database unless they belong to a list (or recipe in the case of ingredients). Also note that when returning a list with ingredients the ingredients will be returnd i three parts<br>
                        name: string<br>
                        amount: number;<br>
                        unit_of_measurement: string
                        
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
