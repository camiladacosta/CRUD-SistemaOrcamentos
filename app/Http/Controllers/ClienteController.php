<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Cliente;
use App\Models\Endereco;

class ClienteController extends Controller
{
    public function consumir()
    { //ECEMPLO DE API PARA CONSUMIR
        $response = Http::get('http://localhost:8000/api/clientes');
        dd($response->json());
    }

    public function clientes()
    {
        return view('cliente.create');
    }

    public function showall()
    {
        $endereco = Endereco::all();
        $search = request('search');
        $searchEnd = request('searchEnd');
        if ($search) {
            $cliente = Cliente::where('nome', 'like', '%' . $search . '%') //BUSCA PELO NOME
                ->orWhere('cpf', 'like', '%' . $search . '%')->get(); //BUSCA PELO CPF
        } else if ($searchEnd) {
            $cli = Endereco::select('enderecos.id_cliente')->pluck('id_cliente');
            foreach ($cli as $cli) {
            }
            $cliente = Cliente::select('clientes.nome', 'clientes.cpf', 'clientes.telefone')
                ->join('enderecos', 'clientes.id', '=', 'enderecos.id_cliente')
                ->where('cidade', 'like', "%{$searchEnd}%")->get();

            $e = Endereco::select('enderecos.cidade')
                ->join('clientes', 'enderecos.id_cliente', '=', 'clientes.id')
                ->where('cidade', 'like', "%{$searchEnd}%")->pluck('cidade');
            foreach ($e as $e) {
            }
            return view('cliente/showall', ['cliente' => $cliente, 'endereco' => $endereco, 'e' => $e, 'cli' => $cli]);
        } else {
            $cliente = Cliente::all();
        }

        return view('cliente/showall', ['cliente' => $cliente, 'endereco' => $endereco]);
    }

    public function create()
    {
        return view('cliente.create');
    }

    public function store(Request $request)
    {
        $cliente = new Cliente;

        $cliente->nome = $request->nome;
        $cliente->cpf = $request->cpf;
        $cliente->telefone = $request->telefone;
        $cliente->email = $request->email;
        $cliente->profissao = $request->profissao;

        $cliente->save();

        $endereco = new Endereco;

        $endereco->cep = $request->cep;
        $endereco->logradouro = $request->logradouro;
        $endereco->numero = $request->numero;
        $endereco->complemento = $request->complemento;
        $endereco->cidade = $request->cidade;
        $endereco->estado = $request->estado;
        $endereco->id_cliente = $cliente->id;

        $endereco->save();

        return redirect('/');
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        $endereco = Endereco::findOrFail($id); //RETORNA COM O ID DO ENDERECO REFERENTE AO CLIENTE
        return view('cliente.show', ['cliente' => $cliente, 'endereco' => $endereco]); //só funciona se o id dos dois for igual
    }

    public function edit($id)
    {
        $cliente = Cliente::find($id);
        $endereco = Endereco::find($id);
        return view('cliente.create', compact('cliente', 'endereco'));
    }

    // ALTERAR DADOS DAS TABELAS CLIENTE E ENDERECO
    public function update(Request $request, $id)
    {
        Cliente::where(['id' => $id])->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'profissao' => $request->profissao,
        ]);
        Endereco::where(['id' => $id])->update([
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'cidade' => $request->cidade,
            'estado' => $request->estado
        ]);
        return redirect('/');
    }

    public function destroy($id)
    {
        Cliente::findOrFail($id)->delete();
        Endereco::findOrFail($id)->delete();
        return redirect('/');
    }

    // public function search(Request $request){
    //     //dd($request->all());
    //     $clientes = $this->repo->search($request->filter);
    //     //return view('cliente.showall',['cliente' => $clientes]);
    // }
}
