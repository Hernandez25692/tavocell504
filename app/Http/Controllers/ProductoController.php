<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\HistorialPrecioProducto;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $productos = Producto::when($buscar, function ($query, $buscar) {
            $query->where('nombre', 'like', "%$buscar%")
                ->orWhere('codigo', 'like', "%$buscar%");
        })->orderBy('nombre')->paginate(10);

        return view('productos.index', compact('productos'));
    }


    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string|unique:productos',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'proveedor' => 'nullable|string',

            // Celular
            'es_celular' => 'nullable|boolean',
            'imei' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'ram' => 'nullable|string|max:50',
            'almacenamiento' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'sistema_operativo' => 'nullable|string|max:50',
        ]);

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'proveedor' => $request->proveedor,
            'es_celular' => $request->has('es_celular') ? 1 : 0,

            'imei' => $request->imei,
            'color' => $request->color,
            'ram' => $request->ram,
            'almacenamiento' => $request->almacenamiento,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'sistema_operativo' => $request->sistema_operativo,
        ]);

        HistorialPrecioProducto::create([
            'producto_id' => $producto->id,
            'precio_compra' => $producto->precio_compra,
            'precio_venta' => $producto->precio_venta,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }


    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string|unique:productos,codigo,' . $producto->id,
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'proveedor' => 'nullable|string',

            // Celular
            'es_celular' => 'nullable|boolean',
            'imei' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'ram' => 'nullable|string|max:50',
            'almacenamiento' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:50',
            'modelo' => 'nullable|string|max:50',
            'sistema_operativo' => 'nullable|string|max:50',
        ]);

        $producto->update([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'proveedor' => $request->proveedor,


            'es_celular' => $request->has('es_celular') ? 1 : 0,

            'imei' => $request->imei,
            'color' => $request->color,
            'ram' => $request->ram,
            'almacenamiento' => $request->almacenamiento,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'sistema_operativo' => $request->sistema_operativo,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }


    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function buscarPorCodigo($codigo)
    {
        $producto = Producto::where('codigo', $codigo)->first();

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            'nombre' => $producto->nombre,
            'stock' => $producto->stock
        ]);
    }
}
