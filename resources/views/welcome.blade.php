@extends('layouts.app')

@section('content')
    <div id="mainWrapper">
        <div id="form-title" class="uk-card uk-card-primary uk-card-body">
            <p>Invoice <a href="" class="uk-icon-button" uk-icon="plus"></a></p>
        </div>
        <div class="main-wrapper">
            <form class="uk-grid-small" uk-grid>
                <div class="uk-width-1-3">
                    <input class="uk-input uk-form-small" type="text" placeholder="Customer">
                </div>
                <div class="uk-width-1-6">
                    <input class="uk-input uk-form-small" type="text" placeholder="From Date">
                </div>
                <div class="uk-width-1-6">
                    <input class="uk-input uk-form-small" type="text" placeholder="Status">
                </div>
                <div class="uk-width-1-6">
                    <button class="uk-button uk-button-primary uk-button-small">Search</button>
                </div>
            </form>

            <table class="uk-table uk-table-striped uk-table-small uk-table-divider">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Table Data</td>
                    <td>Table Data</td>
                    <td>Table Data</td>
                    <td>Table Data</td>
                    <td>
                        <a href="" class="uk-icon-link" uk-icon="pencil"></a>
                        <a href="" class="uk-icon-link" uk-icon="trash"></a>
                    </td>
                </tr>
                <tr>
                    <td>Table Data</td>
                    <td>Table Data</td>
                    <td>Table Data</td>
                    <td>Table Data</td>
                    <td>
                        <a href="" class="uk-icon-link" uk-icon="pencil"></a>
                        <a href="" class="uk-icon-link" uk-icon="trash"></a>
                    </td>
                </tr>
                </tbody>
            </table>
            <ul class="uk-pagination uk-flex-center" uk-margin>
                <li><a href="#"><span uk-pagination-previous></span></a></li>
                <li><a href="#">1</a></li>
                <li class="uk-disabled"><span>...</span></li>
                <li><a href="#">5</a></li>
                <li><a href="#">6</a></li>
                <li class="uk-active"><span>7</span></li>
                <li><a href="#">8</a></li>
                <li><a href="#"><span uk-pagination-next></span></a></li>
            </ul>
        </div>
    </div>
@endsection
