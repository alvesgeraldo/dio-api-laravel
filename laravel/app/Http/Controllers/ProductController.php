<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function buscarTodosProdutos()
    {
        $produtos = Product::all();

        return response()->json($produtos);
    }

    public function buscarProduto(int $id)
    {
        $id = intval($id);
        $produto = Product::find($id);

        if ($produto) {
            return response()->json($produto, Response::HTTP_OK);
        } else {
            return response()->json(
                ["message" => "Produto não encontrado"],
                Response::HTTP_NOT_FOUND
            );
        }

    }

    public function criarProduto(Request $request)
    {
        $data = [];

        try {
            $request->validate([
                "nome" => "required|min:10|max:150",
                "valor" => "required|numeric|regex:/^\d+(\.\d{1,2})?$/"
            ]);

            $data['nomeProduto'] = $request->input('nome');
            $data['valor'] = $request->input('valor');

            if ( $request->has('qtde') ) {
                $data['qtdeEstoque'] = $request->input('valor');
            }

            $res = Product::createProduct($data);

            if ($res) {
                return response()->json(
                    ["message" => "Produto criado com sucesso"],
                    Response::HTTP_CREATED
                );
            } else {
                return response()->json(
                    ["message" => "Erro ao criar produto"],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        } catch (ValidationException $e) {
            return response()->json(
                ["message" => $e->errors()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function atualizarProduto(int $id, Request $request)
    {
        if (!$request->hasAny(['nome', 'valor', 'qtde'])) {
            return response()->json(
                ["message" => "Nenhum dado foi enviado para atualização"],
                Response::HTTP_BAD_REQUEST
            );
        }

        $request->validate([
            "nome" => "sometimes|min:10|max:150",
            "valor" => "sometimes|numeric|regex:/^\d+(\.\d{1,2})?$/"
        ]);

        $produto = Product::find($id);

        if (!$produto) {
            return response()->json(
                ["message" => "Produto não encontrado"],
                Response::HTTP_NOT_FOUND
            );
        }

        if ($request->filled('nome')) {
            $produto->nomeProduto = $request->input('nome');
        }

        if ($request->filled('valor')) {
            $produto->valor = $request->input('valor');
        }

        if ($request->filled('qtde')) {
            $produto->qtdeEstoque = $request->input('qtde');
        }

        $produto->save();

        return response()->json(["message" => "Produto atualizado"], Response::HTTP_OK);

    }

    public function deletarProduto(int $id)
    {
        $produto = Product::find($id);

        if (!$produto) {
            return response()->json(
                ["message" => "Produto não encontrado"],
                Response::HTTP_NOT_FOUND
            );
        }

        $produto->delete();

        return response()->json(
            ["message" => "Produto excluído com sucesso"],
            Response::HTTP_OK
        );
    }
}
