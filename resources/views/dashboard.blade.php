<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th rowspan="2"></th>
                <th rowspan="2"></th>
                <th rowspan="2">Job</th>
                <th colspan="7">
                    Monday<br />
                    27/2/17
                </th>
                <th colspan="7">
                    Tuesday<br />
                    28/2/17
                </th>
                <th colspan="7">
                    Wednesday<br />
                    1/3/17
                </th>
                <th colspan="7">
                    Thursday<br />
                    2/3/17
                </th>
                <th colspan="7">
                    Friday<br />
                    3/3/17
                </th>
            </tr>
            <tr class="time-row">
                @for($i = 0; $i < 5; $i++)
                    <th>9am</th>
                    <th>10am</th>
                    <th>11am</th>
                    <th>12pm</th>
                    <th>2pm</th>
                    <th>3pm</th>
                    <th>4pm</th>
                @endfor
            </tr>
        </thead>
        @foreach($entries as $entry)
            <tr>
                @if($entry->user->id == $entry->user->category->users->first()->id && $entry->id == $entry->user->entries->first()->id)
                    <td rowspan="{{ $entry->user->category->entries->count() }}" class="category-{{ strtolower($entry->user->category->description) }}">
                            <div style="transform: rotate(90deg);">{{ $entry->user->category->description }}</div>
                    </td>
                @endif
                @if($entry->id == $entry->user->entries->first()->id)
                    <td rowspan="{{ $entry->user->entries->count() }}" class="user-{{ strtolower($entry->user->category->description) }}">
                        {{ $entry->user->name }}
                    </td>
                @endif
                <td title="Client: {{ $entry->client->name }}&#013;Account Manager: {{ $entry->client->accountManager->name }}">
                    {{ $entry->description }}
                </td>
                <td>
                    <p>1</p>
                </td>
                <td>
                    <p>2</p>
                </td>
                <td>
                    <p>3</p>
                </td>
                <td>
                    <p>4</p>
                </td>
                <td>
                    <p>5</p>
                </td>
                <td>
                    <p>6</p>
                </td>
                <td>
                    <p>7</p>
                </td>
                <td>
                    <p>8</p>
                </td>
                <td>
                    <p>9</p>
                </td>
                <td>
                    <p>10</p>
                </td>
                <td>
                    <p>11</p>
                </td>
                <td>
                    <p>12</p>
                </td>
                <td>
                    <p>13</p>
                </td>
                <td>
                    <p>14</p>
                </td>
                <td>
                    <p>15</p>
                </td>
                <td>
                    <p>16</p>
                </td>
                <td>
                    <p>17</p>
                </td>
                <td>
                    <p>18</p>
                </td>
                <td>
                    <p>19</p>
                </td>
                <td>
                    <p>20</p>
                </td>
                <td>
                    <p>21</p>
                </td>
                <td>
                    <p>22</p>
                </td>
                <td>
                    <p>23</p>
                </td>
                <td>
                    <p>24</p>
                </td>
                <td>
                    <p>25</p>
                </td>
                <td>
                    <p>26</p>
                </td>
                <td>
                    <p>27</p>
                </td>
                <td>
                    <p>28</p>
                </td>
                <td>
                    <p>29</p>
                </td>
                <td>
                    <p>30</p>
                </td>
                <td>
                    <p>31</p>
                </td>
                <td>
                    <p>32</p>
                </td>
                <td>
                    <p>33</p>
                </td>
                <td>
                    <p>34</p>
                </td>
                <td>
                    <p>35</p>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>