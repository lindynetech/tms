<?php

namespace Tms\Repositories;

use Tms\ReadinglistNotes;
use DB;

class DBReadinglistNotesRepository implements ReadinglistNotesRepositoryInterface
{
    public function listAll($bid)
    {
        return ReadinglistNotes::where('bid', $bid)
                                ->orderBy('id')
                                ->get();
    }

    public function edit($params)
    {
        extract($params);
        $notes = ReadinglistNotes::findOrFail($nid);
        $notes->title = $note;
        $notes->description = $description;

        $notes->save();
    }

    public function add($params)
    {
        $notes = new ReadinglistNotes;

        extract($params);
        $notes->bid = $bid;
        $notes->title = $note;
        $notes->description = $description;

        $notes->save();

        echo $notes->id;
    }

    public function delete($id)
    {
        $notes = ReadinglistNotes::findOrFail($id);
        $notes->delete();
    }
}
