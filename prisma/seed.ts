const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

async function main() {
  const products = [
    // Existing Local Images
    { id: 1, name: 'Classic Cold Brew', slug: 'classic-cold-brew', description: 'Smooth 24-hour brew.', price: 130.00, category: 'Cold Brew', image: '/images/classic_cold_brew.png', status: 'available' },
    { id: 2, name: 'Nitro Cold Brew', slug: 'nitro-cold-brew', description: 'Creamy nitrogen infused brew.', price: 160.00, category: 'Cold Brew', image: '/images/nitro_cold_brew.png', status: 'available' },
    { id: 11, name: 'Cappuccino', slug: 'cappuccino', description: 'Classic espresso and foam.', price: 140.00, category: 'Milk Based', image: '/images/cappuccino.jpg', status: 'available' },
    { id: 12, name: 'Velvet Latte', slug: 'velvet-latte', description: 'Silk-smooth latte.', price: 145.00, category: 'Milk Based', image: '/images/caramel_latte.png', status: 'available' },
    { id: 20, name: 'Blueberry Muffin', slug: 'blueberry-muffin', description: 'Freshly baked with real berries.', price: 85.00, category: 'Pastries', image: '/images/blueberrymuffin.jpg', status: 'available' },

    // Fix Missing using Premium Unsplash Images
    { id: 16, name: 'Banana Bread', slug: 'banana-bread', description: 'Moist walnut banana bread.', price: 80.00, category: 'Pastries', image: 'https://images.unsplash.com/photo-1541810228801-987a90059bfd?q=80&w=800&auto=format&fit=crop', status: 'available' },
    { id: 17, name: 'Cinnamon Roll', slug: 'cinnamon-roll', description: 'Warm roll with frosting.', price: 105.00, category: 'Pastries', image: 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?q=80&w=800&auto=format&fit=crop', status: 'available' },
    { id: 18, name: 'Chocolate Muffin', slug: 'chocolate-muffin', description: 'Double chocolate chip muffin.', price: 90.00, category: 'Pastries', image: 'https://images.unsplash.com/photo-1607958674115-05b934f8a709?q=80&w=800&auto=format&fit=crop', status: 'available' },
    { id: 19, name: 'Butter Croissant', slug: 'butter-croissant', description: 'Flaky and buttery.', price: 95.00, category: 'Pastries', image: 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=800&auto=format&fit=crop', status: 'available' },
    
    // Frappes
    { id: 21, name: 'Caramel Frappe', slug: 'caramel-frappe', description: 'Dreamy caramel blend.', price: 170.00, category: 'Frappe', image: 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?q=80&w=800&auto=format&fit=crop', status: 'available' },
    { id: 22, name: 'Classic Coffee Frappe', slug: 'classic-coffee-frappe', description: 'Rich blended espresso.', price: 155.00, category: 'Frappe', image: 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=800&auto=format&fit=crop', status: 'available' },
    { id: 30, name: 'Matcha Latte', slug: 'matcha-latte', description: 'Premium ceremonial grade.', price: 150.00, category: 'Milk Based', image: 'https://images.unsplash.com/photo-1515823662273-e940f52de3e7?q=80&w=800&auto=format&fit=crop', status: 'available' },
  ];

  console.log('Syncing all products with premium visuals...');
  for (const p of products) {
    await prisma.product.upsert({
      where: { id: p.id },
      update: p,
      create: p,
    });
  }
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
