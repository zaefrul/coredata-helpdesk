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
        'item': kanbanItems['open'],
        'class': 'bg-light',
    }, {
        'id': '_inprogress',
        'title': 'In Progress',
        'item': kanbanItems["in_progress"],
        'class': 'bg-info',

    }, {
        'id': '_resolved',
        'title': 'Resolved',
        'item': kanbanItems['resolved'],
        'class': 'bg-success',
    }, {
        'id': '_closed',
        'title': 'Closed',
        'item': kanbanItems['closed'],
        'class': 'bg-warning',
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
        boards: setBoard,
        dropEl: function (el, target, source, sibling) {
            // This function is triggered when an item is dropped into a board

            // get url in a tag from the element
            const link = el.querySelector('a').getAttribute('href');
            const breakdown = link.split('/');

            const ticketNumber = breakdown[2].trim();

            //get the board id
            switch(target.parentElement.dataset.id)
            {
                case '_open':
                    var status = 'open';
                    break;
                case '_inprogress':
                    var status = 'in_progress';
                    break;
                case '_resolved':
                    var status = 'resolved';
                    break;
                case '_closed':
                    var status = 'closed';
                    break;
            }

            //create form
            const form = document.createElement('form');
            form.action = "{{ route('incident.kanban.status') }}";
            form.method = 'POST';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="status" value="${status}">
                <input type="hidden" name="id" value="${ticketNumber}">
            `;
            document.body.appendChild(form);
            form.submit();
        },
    });
</script>
@endsection
