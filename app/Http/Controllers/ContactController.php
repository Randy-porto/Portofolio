<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Honeypot: regular visitors never fill this field.
        if ($request->filled('website')) {
            return redirect(route('home').'#kontak')->with('contact_success', 'Terima kasih! Pesan Anda berhasil disimpan.');
        }

        $data = $request->validateWithBag('contact', [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:254'],
            'service' => ['required', Rule::in(['Fotografi', 'Film & video', 'Konten kreatif', 'Web development', 'Kolaborasi lainnya'])],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ], [
            'name.required' => 'Nama Anda perlu diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Alamat email perlu diisi.',
            'email.email' => 'Gunakan alamat email yang valid.',
            'service.required' => 'Pilih jenis proyek terlebih dahulu.',
            'service.in' => 'Pilih jenis proyek yang tersedia.',
            'message.required' => 'Ceritakan sedikit tentang ide Anda.',
            'message.min' => 'Ceritakan ide Anda dalam minimal 10 karakter.',
            'message.max' => 'Pesan maksimal 5.000 karakter.',
        ]);

        Inquiry::create($data);

        return redirect(route('home').'#kontak')->with('contact_success', 'Terima kasih! Pesan Anda berhasil disimpan.');
    }
}
