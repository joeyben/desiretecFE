<?php

namespace App\Http\Controllers\Frontend\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\ManageContactRequest;
use App\Http\Requests\Frontend\Contact\StoreCallbackRequest;
use App\Http\Requests\Frontend\Contact\StoreContactRequest;
use App\Http\Requests\Frontend\Contact\UpdateContactRequest;
use App\Models\Contact\Contact;
use App\Repositories\Frontend\Contact\ContactRepository;

/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    const BODY_CLASS = 'contact';

    /**
     * @var ContactRepository
     */
    protected $contact;

    /**
     * @param \App\Repositories\Frontend\Contact\ContactRepository $contact
     */
    public function __construct(ContactRepository $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @param \App\Http\Requests\Frontend\Contact\ManageContactRequest $request
     *
     * @return mixed
     */
    public function index(ManageContactRequest $request)
    {
    }

    /**
     * @param \App\Http\Requests\Frontend\Contact\StoreContactRequest $request
     *
     * @return mixed
     */
    public function store(StoreContactRequest $request)
    {
        $contact = $this->contact->create($request->except('_token'));

        return response()->json([
            'success' => true,
            'message' => trans('alerts.frontend.contact.success')
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Contact\StoreCallbackRequest $request
     *
     * @return mixed
     */
    public function storeCallback(StoreCallbackRequest $request)
    {
        $contact = $this->contact->create($request->except('_token'));

        return response()->json([
            'success' => true,
            'message' => trans('alerts.frontend.contact.success')
        ]);
    }

    /**
     * @param \App\Models\Contact\Contact                              $contact
     * @param \App\Http\Requests\Frontend\Contact\ManageContactRequest $request
     *
     * @return mixed
     */
    public function edit(Contact $contact, ManageContactRequest $request)
    {
        return view('frontend.contact.edit')->with([
            'contact'               => $contact,
            'status'                => $this->status,
            'category'              => $this->category,
            'catering'              => $this->catering,
            'body_class'            => $this::BODY_CLASS,
        ]);
    }

    /**
     * @param \App\Models\Contact\Contact                              $contact
     * @param \App\Http\Requests\Frontend\Contact\UpdateContactRequest $request
     *
     * @return mixed
     */
    public function update(Contact $contact, UpdateContactRequest $request)
    {
        $input = $request->all();

        $this->contact->update($contact, $request->except(['_token', '_method']));

        return redirect()
            ->route('frontend.contact.index')
            ->with('flash_success', trans('alerts.frontend.contact.updated'));
    }

    /**
     * @param \App\Models\Contact\Contact                              $contact
     * @param \App\Http\Requests\Frontend\Contact\ManageContactRequest $request
     *
     * @return mixed
     */
    public function destroy(Contact $contact, ManageContactRequest $request)
    {
        $this->contact->delete($contact);

        return redirect()
            ->route('admin.contact.index')
            ->with('flash_success', trans('alerts.frontend.contact.deleted'));
    }
}
