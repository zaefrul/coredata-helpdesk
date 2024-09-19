@extends('layouts.main')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title-group align-items-start mb-3">
                            <div class="card-title">
                                <h4 class="title">Incident Kanban Board</h4>
                            </div>
                            <div class="media media-middle media-circle media-sm text-bg-primary-soft">
                                <em class="icon icon-md ni ni-user-alt-fill"></em>
                            </div>
                        </div>
                        <div id="kanbanDefault" class="js-kanban"></div>
                    </div><!-- .card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

    // each board item from controller
    let kanbanItems = @json($kanban)

    console.log(kanbanItems)

    let  kanbanDefault ={
    options : {
        gutter:'0',
    },
    boards: [{
        'id': '_open',
        'title': 'Open',
        'item': [{ title: '<span class="badge text-bg-primary">Hello</span>'}, ...kanbanItems['open']]
    }, {
        'id': '_inprogress',
        'title': 'In Progress',
        'item': kanbanItems["in_progress"]
    }, {
        'id': '_resolved',
        'title': 'Resolved',
        'item': kanbanItems['resolved']
    }, {
        'id': '_closed',
        'title': 'Closed',
        'item': kanbanItems['closed']
    }]
} 

let kanbanColored = {
    options : {
        gutter:'0'
    },
    boards:[{
        'id': '_open',
        'title': 'Open',
        'item': [{
                'title': '<span>You can drag me too</span>',
            },
            {
                'title': '<span>Buy Milk</span>',
            }
        ]
    }, {
        'id': '_inprogress',
        'title': 'In Progress',
        'item': [{
                'title': '<span>Do Something!</span>',
            },
            {
                'title': '<span>Run?</span>',
            }
        ]
    }, ]
}

    let item = document.querySelector('.js-kanban');
    let getData = item.id && eval(item.id);
    let getOptions = getData.options ? getData.options : false;
    let setBoard = (typeof boards === 'undefined') ? getData.boards : boards;
    let kanban = new jKanban({
        element: `#${item.id}`,
        gutter: getOptions.gutter ? getOptions.gutter : 0,
        widthBoard: getOptions.widthBoard ? getOptions.widthBoard : '250px',
        boards: setBoard
    });
</script>
@endsection
