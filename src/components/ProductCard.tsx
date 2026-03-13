"use client";
import { Eye, Plus } from 'lucide-react';
import { motion } from 'framer-motion';
import { useCart } from '@/lib/CartContext';
import { useRouter } from 'next/navigation';

interface ProductCardProps {
  product: {
    id: number;
    name: string;
    description: string;
    price: number | string;
    image: string;
    category: string;
  };
}

export default function ProductCard({ product }: ProductCardProps) {
  const { addToCart } = useCart();
  const router = useRouter();

  if (!product) return null;

  return (
    <motion.div 
      initial={{ opacity: 0, y: 20 }}
      whileInView={{ opacity: 1, y: 0 }}
      viewport={{ once: true }}
      className="bg-white rounded-[2rem] overflow-hidden border border-coffee-50 shadow-sm hover:shadow-2xl transition-all group flex flex-col"
    >
      <div className="h-56 overflow-hidden relative">
        <img 
          src={product.name.toLowerCase().includes('banana bread') ? '/images/bananabread.jpg' : (product.image || '/images/default.png')} 
          alt={product.name || 'Product'} 
          className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
        />
        <div className="absolute top-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
           <Plus 
             className="h-5 w-5 text-coffee-900 cursor-pointer hover:rotate-90 transition-transform" 
             onClick={() => addToCart({ ...product, quantity: 1 })}
           />
        </div>
      </div>

      <div className="p-6 flex flex-col flex-grow">
        <h3 className="text-xl font-bold text-coffee-950 mb-1">{product.name}</h3>
        <div className="text-2xl font-black text-coffee-900 mb-6">₱{Number(product.price).toFixed(2)}</div>
        
        {/* View Detail Button */}
        <button 
          onClick={() => router.push(`/menu/${product.id}`)}
          className="w-full bg-[#D4A373] text-white py-3 rounded-xl font-bold flex items-center justify-center space-x-2 hover:bg-[#B68A5D] transition-all shadow-md active:scale-95"
        >
          <Eye className="h-5 w-5" />
          <span>View Detail</span>
        </button>
      </div>
    </motion.div>
  );
}
